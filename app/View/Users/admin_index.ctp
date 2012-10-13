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
            { display: '名字', name: 'name', type: 'text', align:'left', minWidth:150, width:150},
            { display: '昵称', name: 'nickname', type: 'text', isSort:false, minWidth:300, align:'left', editor:{type:'text'}},
            { display: '操作人', name: 'operate', type: 'text', minWidth:50, width:50},
            { display: '创建时间', name:'created', type: 'text', isSort: false, align:'center'}
            ],
            enabledEdit: true,  
            enabledSort: true,
            //clickToEdit: false,
            isScroll: true, 
            rownumbers:true,
            checkbox: true,
            dataAction: 'server',
            url: '/admin/users',
            method: 'post',
            pageSize: 20,
            height: '100%',
            pagesizeParmName: 'limit',
            root: 'data',
            record: 'total',
            sortnameParmName: 'sort',
            sortorderParmName: 'order',
            heightDiff:-50,
            onAfterEdit: function(e){
                var _id = e.record.id, _value = e.value, _field = e.column.columnname;

                $.post('<?php echo $this->Html->url('/admin/users/update'); ?>', {id:_id, field:_field, value: _value}, function(_data){
                    var _code = _data.code | 0;
                    if ( _code ) $.ligerDialog.warn(_data.msg, '提示');
                }, 'json');
            }
    };

    grid_table = manager = $("#maingrid").ligerGrid(_grid_init);

    $("#new_row").bind('click', function(){

    });

    $("#del_row").bind('click', function(){

    });

    $("#del_row").bind('click', function(){

    });
});
</script>
