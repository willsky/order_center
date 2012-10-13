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
            { display: '主键', name: 'id', width: 50, type: 'int',frozen:true },
            { display: '名字', name: 'name', type: 'text', align:'left', minWidth:300, editor:{type:'text'}},
            { display: '价格', name: 'actions', type: 'text', isSort: false, width:100, align:'left', editor:{type:'text'}},
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
            heightDiff:-50,
            pagesizeParmName: 'limit',
            onAfterEdit: function(e){
                var _id = e.record.id, _value = e.value, _field = e.column.columnname;

                $.post('<?php echo $this->Html->url('/admin/products/update'); ?>', {id:_id, field:_field, value: _value}, function(_data){
                    console.log(_data);
                }, 'json');
            }
    };

    grid_table = manager = $("#maingrid").ligerGrid(_grid_init);

    $("#new_row").bind('click', function(){

    });

});
</script>
