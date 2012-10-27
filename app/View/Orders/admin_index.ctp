<div id="maingrid"></div>

<script type="text/javascript">
var manager = null, grid_table = null, user_win= null;

$(function(){
    _grid_init = {
        columns: [
            { display: '订单号', name: 'id', width: 100, type: 'int', align:'left'},
            { display: '产品', name: 'product_name', type: 'text', align:'left', minWidth:100},
            { display: '客户姓名', name: 'customer_realname', type: 'text', isSort:false, minWidth:80, align:'left'},
            { display: '客户电话', name: 'customer_telephone', type: 'text', minWidth:100, align:'left'},
            { display: '客户邮件/QQ', name: 'customer_email', type: 'text', isSort:false, minWidth:150, align:'left'},
            { display: '客户邮编', name: 'customer_postal', type: 'text', isSort:false, minWidth:80, align:'center'},
            { display: '客户地址', name: 'customer_address', type: 'text', isSort:false, minWidth:200, align:'center'},
            { display: '订单状态', name: 'state', type: 'text', isSort:false, minWidth:80, align:'center'},
            { display: '物流', name: 'transport', type: 'text', isSort:false, minWidth:100, align:'center'},
            { display: '支付方式', name: 'payment', type: 'text', isSort:false, minWidth:100, align:'center'},
            { display: '发货人', name: 'sender', type: 'text', isSort:false, minWidth:100, align:'center'},
            { display: '创建时间', name: 'created', type: 'text', isSort:false, minWidth:100, align:'center'},
            { display: '发货时间', name: 'updated', type: 'text', isSort:false, minWidth:100, align:'center'}
            ],
            enabledEdit: true,  
            enabledSort: true,
            rownumbers:true,
            //checkbox: true,
            dataAction: 'server',
            url: '/admin/orders',
            method: 'post',
            pageSize: 20,
            height: '100%',
            pagesizeParmName: 'limit',
            root: 'data',
            record: 'total',
            sortnameParmName: 'sort',
            sortorderParmName: 'order'
    };

    grid_table = manager = $("#maingrid").ligerGrid(_grid_init);
});
</script>
