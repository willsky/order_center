<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * @copyright     Copyright 2005-2012,iDreamsky.com 
 * @link          http://www.idreamsky.com CakePHP(tm) Project
 * @package       Cake.View.Layouts
 * @since         LeDou.iDreamsky v 0.08.07.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $title_for_layout; ?>
	</title>
	<?php
	echo $this->Html->meta('icon');
	echo $this->fetch('meta');
	echo $this->fetch('css');
	echo $this->fetch('script');
	echo $this->Html->css('liger/skins/Aqua/css/ligerui-all');
	?>
	<style type="text/css">
    body,html{height:100%;}
    body{ padding:0px; margin:0;   overflow:hidden;}  
    .l-link{ display:block; height:26px; line-height:26px; padding-left:10px; text-decoration:underline; color:#333;}
    .l-link2{text-decoration:underline; color:white; margin-left:2px;margin-right:2px;}
    .l-layout-top{background:#102A49; color:White;}
    .l-layout-bottom{ background:#E5EDEF; text-align:center;}
    #pageloading{position:absolute; left:0px; top:0px; background:white url('img/liger/loading.gif') no-repeat center; width:100%; height:100%;z-index:99999;}
    .l-link{ display:block; line-height:22px; height:22px; padding-left:16px;border:1px solid white; margin:4px;}
    .l-link-over{ background:#FFEEAC; border:1px solid #DB9F00;} 
    .l-winbar{ background:#2B5A76; height:30px; position:absolute; left:0px; bottom:0px; width:100%; z-index:99999;}
    .space{ color:#E7E7E7;}
    /* 顶部 */ 
    .l-topmenu{ margin:0; padding:0; height:31px; line-height:31px; background:url('img/liger/top.jpg') repeat-x bottom;  position:relative; border-top:1px solid #1D438B;  }
    .l-topmenu-logo{ color:#E7E7E7; padding-left:35px; line-height:26px;background:url('img/liger/topicon.gif') no-repeat 10px 5px;}
    .l-topmenu-welcome{  position:absolute; height:24px; line-height:24px;  right:30px; top:2px;color:#070A0C;}
    .l-topmenu-welcome a{ color:#E7E7E7; text-decoration:underline} 
	#topmenu a {text-decoration:none; color:#FFF; }
	</style>
</head>
<body style="padding:0px;background:#EAEEF5;">  
<div id="pageloading"></div>  
<div id="topmenu" class="l-topmenu">
	<!--<div class="l-topmenu-logo"><?php echo $this->Html->link($Description, 'http://'); ?></div>!-->
	<div class="l-topmenu-logo">订单管理中心</div>
</div>
  <div id="layout1" style="width:99.2%; margin:0 auto; margin-top:4px; "> 
        <div position="left"  title="控制面板" id="accordion1"> 
                    <div title="产品管理" class="l-scroll">
                         <ul id="tree1" style="margin-top:3px;">
                    </div>
                    <div title="订单管理" class="l-scroll">
                         <ul id="tree2" style="margin-top:3px;">
                    </div>    
                     <div title="用户管理" class="l-scroll">
                         <ul id="tree3" style="margin-top:3px;">
                    </div> 
        </div>
        <div position="center" id="framecenter"> 
            <div tabid="home" title="我的主页" style="height:300px" >
			<iframe frameborder="0" name="home" id="home" src="<?php echo $this->Html->url('/pages/display'); ?>"></iframe>
            </div> 
        </div> 
        
    </div>
    <div  style="height:32px; line-height:32px; text-align:center;">
            Copyright (C) 2012 
    </div>
	<div style="display:none"><?php echo $this->element('sql_dump'); ?></div>
</body>
<?php
	echo $this->Html->script(array('lib/jquery/jquery-1.5.2.min', 'lib/ligerUI/js/ligerui.min', 'menu_data'));
?>
<script type="text/javascript">
var tab = null;
var accordion = null;
var tree = null;

$(function ()
{

	//布局
	$("#layout1").ligerLayout({ leftWidth: 190, height: '100%',heightDiff:-34,space:4, onHeightChanged: f_heightChanged });

	var height = $(".l-layout-center").height();

	//Tab
	$("#framecenter").ligerTab({ height: height });

	//面板
	$("#accordion1").ligerAccordion({ height: height - 24, speed: null });

	$(".l-link").hover(function ()
	{
		$(this).addClass("l-link-over");
	}, function ()
	{
		$(this).removeClass("l-link-over");
	});
	// 树
	$("#tree1").ligerTree({
		data : indexdata0,
		checkbox: false,
		slide: false,
		nodeWidth: 120,
		attribute: ['nodename', 'url'],
		onSelect: function (node)
		{
			if (!node.data.url) return;
			var tabid = $(node.target).attr("tabid");
			if (!tabid)
			{
				tabid = new Date().getTime();
				$(node.target).attr("tabid", tabid)
			} 
			f_addTab(tabid, node.data.text, node.data.url);
		}
	});

	$("#tree2").ligerTree({
		data : indexdata1,
		checkbox: false,
		slide: false,
		nodeWidth: 120,
		attribute: ['nodename', 'url'],
		onSelect: function (node)
		{
			if (!node.data.url) return;
			var tabid = $(node.target).attr("tabid");
			if (!tabid)
			{
				tabid = new Date().getTime();
				$(node.target).attr("tabid", tabid)
			} 
			f_addTab(tabid, node.data.text, node.data.url);
		}
	});

	$("#tree3").ligerTree({
		data : indexdata2,
		checkbox: false,
		slide: false,
		nodeWidth: 120,
		attribute: ['nodename', 'url'],
		onSelect: function (node)
		{
			if (!node.data.url) return;
			var tabid = $(node.target).attr("tabid");
			if (!tabid)
			{
				tabid = new Date().getTime();
				$(node.target).attr("tabid", tabid)
			} 
			f_addTab(tabid, node.data.text, node.data.url);
		}
	});

	tab = $("#framecenter").ligerGetTabManager();
	accordion = $("#accordion1").ligerGetAccordionManager();
	tree = $("#tree1").ligerGetTreeManager();
	$("#pageloading").hide();

});

function f_heightChanged(options)
{
	if (tab)
		tab.addHeight(options.diff);
	if (accordion && options.middleHeight - 24 > 0)
		accordion.setHeight(options.middleHeight - 24);
}
function f_addTab(tabid,text, url)
{ 
	tab.addTabItem({ tabid : tabid,text: text, url: url });
} 
</script> 
</html>
