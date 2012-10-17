<div style="margin: 10px auto">
	<a class="l-button" style="width:80px; float:left; margin-left:10px;" id="new_row">添加</a>
	<a class="l-button" style="width:80px; float:left; margin-left:10px;" id="del_row">删除</a>
</div>
<div class="l-clear"></div>

<div id="maingrid" style="margin: 10px;"></div>
<script type="text/javascript">
var manager, grid_table;

$(function(){
    _grid_init = {
        columns: [
            { display: '主键', name: 'id', width: 50, type: 'int', isSort: true, frozen:true },
            { display: '名字', name: 'product_name', type: 'text', align:'left', isSort: true, minWidth:300},
            { display: '价格', name: 'price', type: 'text', isSort: false, width:100, align:'left'},
            ],
            enabledEdit: true,  
            enabledSort: true,
            //clickToEdit: false,
            isScroll: true, 
            rownumbers:true,
            checkbox: true,
            dataAction: 'server',
            url: '/admin/products',
            method: 'post',
            pageSize: 20,
            height: '100%',
            pagesizeParmName: 'limit',
            root: 'data',
            record: 'total',
            sortnameParmName: 'sort',
            sortorderParmName: 'order',
            heightDiff:-50
    };

    grid_table = manager = $("#maingrid").ligerGrid(_grid_init);

    $("#new_row").bind('click', function(){

    });

});
</script>
