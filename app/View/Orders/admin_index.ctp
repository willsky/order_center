<div id="maingrid"></div>

<script type="text/javascript">
var manager = null, grid_table = null, user_win= null;
var order_states = top.getOrderState(); 
var transports = top.getTransportList();
var payments = top.getPayments();

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

    grid_table = manager = $("#maingrid").ligerGrid(_grid_init);
});
</script>
