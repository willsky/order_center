
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

//$Description = __d('Game Center', '乐逗游戏中心欢迎页面');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $title_for_layout; ?>
		<?php //echo $Description ?>:
	</title>
<?php
	echo $this->Html->meta('icon');
	echo $this->fetch('meta');
	echo $this->fetch('css');
	echo $this->fetch('script');
	echo $this->Html->css('liger/skins/Aqua/css/ligerui-all');
	echo $this->Html->script(array('lib/jquery/jquery-1.5.2.min', 'lib/ligerUI/js/ligerui.min')); 
?>
</head>
<body style="padding:10px;">
    <?php //echo $this->Session->flash(); ?>
    <?php echo $this->fetch('content'); ?>
    <?php echo $this->element('sql_dump'); ?>
</body>
</html>
<script type="text/javascript">
    $(function(){
        var username = "<?php echo $this->Session->read('User.Info.name'); ?>";

        if (self != top && !username ) {
            top.location.reload();
        }
    });
</script>

