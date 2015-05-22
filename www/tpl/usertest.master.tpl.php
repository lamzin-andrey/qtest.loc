<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
	<title><?=$app->title()?></title>
	<link rel="stylesheet" type="text/css" href="<?=WEB_ROOT ?>/css/styletest.css?v=<?=STATIC_VERSION?>" /><?php
	if (isset($handler->css) && is_array($handler->css) && count($handler->css)) {
		foreach ($handler->css as $css){
		?><link rel="stylesheet" type="text/css" href="<?=$css?>" />
<?php
		}
	}
?>
        <script type="text/javascript" src="<?=WEB_ROOT ?>/js/jquery-1.11.0.min.js"></script>
	<script type="text/javascript" src="<?=WEB_ROOT ?>/js/jquery.cookie.js"></script>
	<script type="text/javascript" src="<?=WEB_ROOT ?>/js/popupwin.js?v=<?=STATIC_VERSION?>"></script>
	<script type="text/javascript" src="<?=WEB_ROOT ?>/js/local.js.php"></script>
	<script type="text/javascript" src="<?=WEB_ROOT ?>/js/lib.js?v=<?=STATIC_VERSION?>"></script>
	<script type="text/javascript" src="<?=WEB_ROOT ?>/js/popupwin.js?v=<?=STATIC_VERSION?>"></script>
	<script type="text/javascript" src="<?=WEB_ROOT ?>/js/app.js?v=<?=STATIC_VERSION?>"></script>
	<script type="text/javascript" src="<?=WEB_ROOT ?>/js/test-engine/js/testengine.js?v=<?=STATIC_VERSION?>"></script>
	<?php include APP_ROOT . '/tpl/std/constants.tpl.php'; ?>
	<?php
	if (isset($handler->js) && is_array($handler->js) && count($handler->js)) {
		foreach ($handler->js as $js){
		?><script type="text/javascript" charset="UTF-8" src="<?=WEB_ROOT ?><?=$js?>"></script>
	<?
		}
	}
	?>		
<?php if (sess('messages')):?>
	<script type="text/javascript">
		var infoMessages = <?=json_encode(sess('messages'))?>;
		<?php unset($_SESSION['messages']);?>
	</script>
<?php else:?>
	<script type="text/javascript">
            var infoMessages = {};
	</script>
<?php endif ?>
</head>
<body><img src="<?=WEB_ROOT?>/img/std/back_text.png" class="pload" />
	<div class="main center relative">
            <div class="toolbar">
                    <?php include APP_ROOT . '/tpl/qtest/toolbar.php'?>
            </div>
            <div id="tooltip" class="right bg-dark-blue"></div>
            <div class="simple_page_content">
                    <?php
                            if (isset($handler->right_inner)) {
                                    include $handler->right_inner;
                            }
                     ?>
            </div>
	</div>
</body>
</html> 
