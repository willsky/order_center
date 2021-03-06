<div style="margin: 0px 0px 10px 0px;">
    <table>
        <tr>
            <td>订单状态：</td>
            <td><input type="text" id="txt_order_states" /><input type="hidden" id="val_order_states" /></td>
            <td>物流方式：</td>
            <td><input type="text" id="txt_transport" /><input type="hidden" id="val_transport" /></td>
            <td width="10"></td>
            <td><div id="search"></div></td>
        </tr>
    </table>
</div>
<div id="maingrid"></div>

<script type="text/javascript">
var manager = null, grid_table = null, user_win= null;
var order_states = top.getOrderState(); 
var transports = top.getTransportList();
var payments = top.getPayments();
var sel_order_state = null, sel_transport = null;

$(function(){
    _grid_init = {
        columns: [
            { display: '订单号', name: 'id', width: 100, type: 'int', align:'left'},
            { display: '产品', name: 'product_name', type: 'text', align:'left', minWidth:100},
            { display: '客户姓名', name: 'customer_realname', type: 'text', isSort:false, minWidth:80, align:'left', editor:{type:'text'}},
            { display: '客户电话', name: 'customer_telephone', type: 'text', minWidth:100, align:'left', editor:{type:'text'}},
            { display: '客户邮件/QQ', name: 'customer_email', type: 'text', isSort:false, minWidth:150, align:'left', editor:{type:'text'}},
            { display: '客户邮编', name: 'customer_postal', type: 'text', isSort:false, minWidth:80, align:'center', editor:{type:'text'}},
            { display: '客户地址', name: 'customer_address', type: 'text', isSort:false, minWidth:200, align:'center', editor:{type:'text'}},
            { display: '订单状态', name: 'state', type: 'text', isSort:true, minWidth:80, align:'center', 
            render:function(_row, _index){
                return top.order_state(_row.state);
            }, editor:{type:'select', data: order_states, valueColumnName: 'state'}
            },
            { display: '物流', name: 'ts_id', type: 'text', isSort:true, minWidth:100, align:'center', 
              render:function(_row, _index){
                return top.transport(_row.ts_id);
              }, editor: { type:'select', data: transports, valueColumnName: 'ts_id'}
            },
            { display: '物流号', name: 'ts_no', type: 'text', isSort:false, minWidth:100, align:'center', editor:{type:'text'}},
            { display: '客户IP', name: 'customer_ip', type: 'text', isSort:false, minWidth:160, align:'center'},
            { display: '发货人', name: 'sender', type: 'text', isSort:false, minWidth:100, align:'center'},
            { display: '下单时间', name: 'created', type: 'text', isSort:true, minWidth:160, align:'center', 
              render:function(_row, _index){
                  return top.strftime(_row.created);
            }},
            { display: '发货时间', name: 'updated', type: 'text', isSort:true, minWidth:100, align:'center', 
              render:function(_row, _index){
                  return top.strftime(_row.updated);
            }}
            ],
            enabledEdit: true,  
            enabledSort: true,
            rownumbers:true,
            //checkbox: true,
            dataAction: 'server',
            url: '/admin/orders/index',
            method: 'post',
            pageSize: 20,
            height: '100%',
            pagesizeParmName: 'limit',
            root: 'data',
            record: 'total',
            sortnameParmName: 'sort',
            sortorderParmName: 'order',
            onAfterEdit: function(e) {
                var _field = e.column.name;
                var _value = e.value;
                var _id = e.record.id | 0;

                $.post('/admin/orders/edit/'+ _id, {field:_field, value:_value}, function(_callback){
                    var _status = _callback.code|0;
                    grid_table.loadServerData();
                });
            } 
    };

    var query_order_states = order_states, query_transports = transports;
    query_order_states.unshift({'state': '', 'text':'所有'});
    query_transports.unshift({'ts_id': '', 'text': '所有'});

    sel_order_state = $("#txt_order_states").ligerComboBox({
        data: query_order_states,
        valueFieldID: 'val_order_states',
        valueField: 'state'
    });

    sel_transport = $("#txt_transport").ligerComboBox({
        data: query_transports,
        valueFieldID: 'val_transport',
        valueField: 'ts_id'
    });

    $("#search").ligerButton({
        text: '搜索',
        click: function(){
            var s_ts_id = null, s_state = null, query = '';

            if ( sel_transport ) {
                s_ts_id = $("#val_transport").val();

                if ( '' != s_ts_id ) {
                    s_ts_id = s_ts_id | 0;
                    query = "ts_id:" + s_ts_id;
                }
            }

            if ( sel_order_state ) {
                s_state = $("#val_order_states").val();

                if ( '' != s_state ) {
                    s_state = s_state | 0;
                    var _join = "";

                    if ( query ) {
                        _join = "|";
                    }
                    query += _join + "state:" + s_state;
                }
            }

            grid_table.setOptions({
                parms: [{name: 'query', value: query}]
            });
            grid_table.loadData(true);
        }
    });

    grid_table = manager = $("#maingrid").ligerGrid(_grid_init);
});
</script>
