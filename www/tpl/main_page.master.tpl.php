<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
	<title><?=$app->title()?></title>
	<link rel="stylesheet" type="text/css" href="<?=WEB_ROOT ?>/css/style.css?v=<?=STATIC_VERSION?>" />
	<link rel="stylesheet" type="text/css" href="<?=WEB_ROOT ?>/css/popupwin.css?v=<?=STATIC_VERSION?>" /><?
	if (isset($handler->css) && is_array($handler->css) && count($handler->css)) {
		foreach ($handler->css as $css){
		?><link rel="stylesheet" type="text/css" href="<?=WEB_ROOT ?>/css/<?=$css?>.css?v=<?=STATIC_VERSION?>" />
<?
		}
	}
	?><script type="text/javascript" src="<?=WEB_ROOT ?>/js/jquery-1.11.0.min.js"></script>
	<script type="text/javascript" src="<?=WEB_ROOT ?>/js/jquery.cookie.js"></script>
	<script type="text/javascript" src="<?=WEB_ROOT ?>/js/popupwin.js?v=<?=STATIC_VERSION?>"></script>
	<script type="text/javascript" src="<?=WEB_ROOT ?>/js/local.js.php"></script>
	<script type="text/javascript" src="<?=WEB_ROOT ?>/js/lib.js?v=<?=STATIC_VERSION?>"></script>
	<script type="text/javascript" src="<?=WEB_ROOT ?>/js/app.js?v=<?=STATIC_VERSION?>"></script>
	<? include APP_ROOT . '/tpl/std/constants.tpl.php'; ?>
	<?
	if (isset($handler->js) && is_array($handler->js) && count($handler->js)) {
		foreach ($handler->js as $js){
		?><script type="text/javascript" charset="UTF-8" src="<?=WEB_ROOT ?>/js/<?=$js?>?v=<?=STATIC_VERSION?>"></script>
	<?
		}
	}
	?>		
<?php if (sess('messages')):?>
	<script type="text/javascript">
		var infoMessages = <?=json_encode(sess('messages'))?>;
		<? unset($_SESSION['messages']);?>
	</script>
<? else:?>
	<script type="text/javascript">
		var infoMessages = {};
	</script>
<? endif ?>
</head>
<body><img src="/img/std/back_text.png" class="pload" />
<div class="toolbar">
	<? include APP_ROOT . '/tpl/std/toolbar.php'?>
</div>
	<div class="main center relative scroll-y">
		<div class="fixed_toolbar_placer">&nbsp;</div>
		<? include APP_ROOT . '/tpl/std/form_auth.tpl.php' ?>
		
		<div id="tooltip" class="right bg-dark-blue"></div>
		<div class="simple_page_content">
			<?
				if (isset($handler->right_inner)) {
					include APP_ROOT . '/tpl/' . $handler->right_inner;
				}
			 ?>
		</div>
		<footer>
			&copy; Lamzin Andrey, 2014.
		</footer>
	</div>
	
	<?//popupwin?>
	<div id="ldrbig" class="hide">
		<img src="<?=WEB_ROOT ?>/img/std/ploader.gif" />
	</div>
	<div class="popupbg hide" id="popupbg"></div>
	<div class="popupbg z6 hide"id="loaderbg"></div>
	<div class="adminpopup hide" id="popup">
		<div class="popup-title-area">
			<div id="popuptitle">...</div>
			<div class="popup-close" onclick="appWindowClose()">
				<img src="<?=WEB_ROOT ?>/img/std/close.png" />
			</div>
		</div>
		<div class="both"></div>
		<div class="popup-content" id="appWindowPopup"></div>
	</div>
	<?// /popupwin?>
	<? include APP_ROOT . '/tpl/std/form_reg.tpl.php' ?>
</body>
</html> 
