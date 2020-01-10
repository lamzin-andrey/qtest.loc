<?php
/** ctrl UserTestPageHandler */
    function select_test_type_v($handler, $k, $default) {
        $h = $handler;
        return ( a( a($h->test, 'options'), $k) !== null ? a( a($h->test, 'options'), $k) : $default );
    }
/*Шаблон в /opt/lampp/htdocs/qtest.loc/www/files/tpl/js/template/*/
?><div class="promo">
	<header>
		<h2><?=$lang['Test_titles'] ?></h2>
	</header>
	<form method="POST" action="<?=(a($handler->test, 'id') ? WEB_ROOT . '/my/' . $handler->test['id']  : WEB_ROOT . '/create_test/')?>" >
		<?php FV::$obj = $handler->test; ?>
		<div class="create_test_title">
			<label class="block" for="display_name"><?php echo $lang["test_title"]; ?></label>
			<?=FV::i('display_name') ?>
		</div>
		<div class="create_test_sdesc">
			<label class="block" for="short_desc"><?php echo $lang["test_short_desc"]; ?></label>
			<?=FV::text('short_desc', 10, array('class' => 'short_desc')) ?>
		</div>
		<div class="create_test_description">
			<label class="block" for="test_description"><?php echo $lang["test_description"]; ?></label>
			<?=FV::text('test_description', 15, array('class' => 'test_description'), a($handler->test, 'description')) ?>
		</div>
		<div class="create_test_info">
			<label class="block" for="info"><?php echo $lang["create_test_info"]; ?></label>
			<div class="create_test_comment"><?php echo $lang["create_test_info_comment"];?></div>
			<?=FV::text('info', 10, array('class' => 'test_info')) ?>
		</div>
                <?php if ( !a($handler->test, 't_type') || a($handler->test, 't_type') === 0):?>
		<header>
			<h2><?=$lang['Select_type_your_test'] ?></h2>
		</header>
		<div class="create_test_radio_item trow btn j-v_type">
			<div class="left type_test_item tcell">
				<?=FV::radio('variantTest', 't_type', $lang['Test_with_variants'], 0); ?>
			</div>
			<div class="right type_test_ill tcell">
				<?=H::img(WEB_ROOT . '/img/qtest/variant_test.png', $lang['User_select_variant_answer'], array('for' =>'variantTest')) ?>
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="create_test_radio_item trow btn j-t_type">
			<div class="left type_test_item tcell">
				<?=FV::radio('textTest', 't_type', $lang['Test_with_text_answer'], 1); ?>
			</div>
			<div class="right type_test_ill tcell">
				<?=H::img(WEB_ROOT . '/img/qtest/text_test.png', $lang['User_typed_your_answer'], array('for' =>'textTest')) ?>
			</div>
			<div class="clearfix"></div>
			<div class="compare_type hid" id="compareType">
				<div class="left compare_type_radio_item trow btn">
					<div class="left type_compare_item tcell">
						<?=FV::radio('strong', 't_compare', $lang['Strong_compare'], 0);//TODO set constant ?>
					</div>
					<div class="right type_compare_help tcell">
						<?=H::a('/help/compare_types#strong', 
								H::img(WEB_ROOT . '/img/std/help_circle_blue_small.png', $lang['More']),
								'',
								true
							); ?>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="left compare_type_radio_item trow btn">
					<div class="left type_compare_item tcell">
						<?=FV::radio('byWord', 't_compare', $lang['Compare_by_word'], 1);//TODO set constant ?>
					</div>
					<div class="right type_compare_help tcell">
						<?=H::a('/help/compare_types#by_word', 
								H::img(WEB_ROOT . '/img/std/help_circle_blue_small.png', $lang['More']),
								'',
								true
							); ?>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
                <?php elseif (a($handler->test, 't_type') == 1): ?>
                
                <header>
			<h2><?=$lang['Select_type_compare_your_test'] ?></h2>
		</header>
		<div class="create_test_radio_item trow btn j-t_type success">
			<div class="left type_test_item tcell">
				<?=FV::hid('t_type', 1); ?>
			</div>
			<div class="right type_test_ill tcell">
				<?=H::img(WEB_ROOT . '/img/qtest/text_test.png', $lang['User_typed_your_answer'], array('for' =>'textTest')) ?>
			</div>
			<div class="clearfix"></div>
			<div class="compare_type hid" id="compareType">
				<div class="left compare_type_radio_item trow btn">
					<div class="left type_compare_item tcell">
						<?=FV::radio('strong', 't_compare', $lang['Strong_compare'], 0, (a($handler->test['options'], 't_compare') === '0' ? true : false) );//TODO set constant ?>
					</div>
					<div class="right type_compare_help tcell">
						<?=H::a('/help/compare_types#strong', 
								H::img(WEB_ROOT . '/img/std/help_circle_blue_small.png', $lang['More']),
								'',
								true
							); ?>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="left compare_type_radio_item trow btn">
					<div class="left type_compare_item tcell">
						<?=FV::radio('byWord', 't_compare', $lang['Compare_by_word'], 1, (a($handler->test['options'], 't_compare') === '1' ? true : false) );//TODO set constant ?>
					</div>
					<div class="right type_compare_help tcell">
						<?=H::a('/help/compare_types#by_word', 
								H::img(WEB_ROOT . '/img/std/help_circle_blue_small.png', $lang['More']),
								'',
								true
							); ?>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
                <?php endif?>
            
		<header>
			<h2><?php echo $lang['Test_times']?></h2>
		</header>
		<div class="create_test_seconds">
			<div><?=FV::labinp('time_decision', $lang['time_wait_answer'], select_test_type_v($handler, 'time_decision', 60), 0, 'number');?> <?=$lang['sec.'] ?></div>
                        <div><?=FV::labinp('time_show_error_message', $lang['time_show_error_message'], select_test_type_v($handler, 'time_show_error_message', 5), 0, 'number');?> <?=$lang['sec.'] ?></div>
                        <div><?=FV::labinp('time_show_success_message', $lang['time_show_success_message'], select_test_type_v($handler, 'time_show_success_message', 3), 0, 'number');?> <?=$lang['sec.'] ?></div>
                        <div><?=FV::labinp('time_show_game_over_message', $lang['time_show_game_over_message'], select_test_type_v($handler, 'time_show_game_over_message',5), 0, 'number');?> <?=$lang['sec.'] ?></div>
                        <div><?=FV::labinp('time_show_win_screen', $lang['time_show_win_screen'], select_test_type_v($handler, 'time_show_win_screen', 15), 0, 'number');?> <?=$lang['sec.'] ?></div>
		</div>
		<header>
			<h2><?php echo $lang['Test_any_params']?></h2>
		</header>
		<div class="create_test_cb"><?=FV::checkbox('is_random', $lang['Test_is_random']) ?></div>
                <div class="create_test_score"><?=FV::labinp('test_score', $lang['Test_score'], select_test_type_v($handler, 'test_score', 5), 0, 'number'); ?></div>
                <div class="create_test_lives"><?=FV::labinp('test_lives', $lang['Test_lives'], select_test_type_v($handler, 'test_lives', 2), 0, 'number'); ?></div>
		<div class="create_test_cb"><?=FV::checkbox('is_skip', $lang['Test_is_skip']) ?></div>
		<div id="skip_params">
                    <div class="create_test_skip_score"><?=FV::labinp('test_skip_score', $lang['Test_skip_price'], select_test_type_v($handler, 'test_skip_score', 1), 0, 'number'); ?></div>
                    <div class="create_test_skip_border"><?=FV::labinp('test_skip_border', $lang['Test_skip_border'], select_test_type_v($handler, 'test_skip_border', 0), 'number'); ?></div>
		</div>
		<div class="create_test_cb"><?=FV::checkbox('show_answer', $lang['Test_show_answer']) ?></div>
		<div class="create_test_skip_success_message"><?=FV::labinp('one_answer_success_message', $lang['Test_one_answer_success_message'], select_test_type_v($handler, 'one_answer_success_message', $lang['ctest_v_is_right']) ); ?></div>
		<div class="create_test_skip_error_message"><?=FV::labinp('one_answer_fail_message', $lang['Test_one_answer_fail_message'], select_test_type_v($handler, 'one_answer_fail_message', $lang['ctest_v_is_fail']) ); ?></div>
		<div class="create_test_skip_gameover_message"><?=FV::labinp('gameover_message', $lang['Test_game_over_message'], select_test_type_v($handler, 'gameover_message', $lang['GAME_OVER']) ); ?></div>
		
		<?php //аплоад файлов ?>
		<?php if (o($handler, 'isEdit') ): ?>
		<div class="my-3">
			<span class=""><?=a($lang, 'Select background image, recomended size 1280 х 800')?></span>
			<label id="chatUploadBtn" class="chat-upload-label">
				<img class="b " src="/img/std/fileopen.png" width="20" height="20">
				<input class="hide" type="file" id="chatfile" name="chatfile" 
					data-url="/chatupload" 
					data-progress="chatOnUploadProgress" 
					data-success="testSettingOnUploadFile" 
					data-fail="chatOnFailUploadFile" 
					data-select-off="chatOnSelectFile">
			</label>
			<div id="chatUploadProcessView" class="relative chat-upload-token-anim-block" style="display:none">
				<div id="chatUploadProcessLeftSide" class="pull-left chat-upload-token-anim-color">&nbsp;</div>
				<div id="chatUploadProcessRightSide" class="pull-left chat-upload-token-anim-color">&nbsp;</div>
				<div class="clearfix"></div>
				<img id="chatUploadProcessTokenImage" src="/img/std/token.png">
				<div id="chatUploadProcessText" style="">9</div>
			</div>
			<input type="button" id="bSetBgImageDefault" value="<?=a($lang, 'Set deafult')?>">
			<div class="relative">
				<input id="bgimage" name="bgimage" type="hidden" value="<?=a($handler->test, 'bgimage')?>">
				<img id="imgBgImage" src="<?=a($handler->test, 'bgimage')?>" style="max-height:200px; max-width:100%;">
				<div id="hTextExample" class="text_example absolute" style="color:<?=a($handler->test, 'text_color')?>; background-color:rgba(255, 255, 255, <?=intval(a($handler->test, 'bg_alpha')) / 100 ?>); <?=$handler->getTextBorder() ?>; font-size:38px;">
					<p><?=a($lang, 'QUESTION TEXT')?></p>
					<p><?=a($lang, 'QUESTION TEXT')?></p>
				</div>
			</div>
			<div>
				<label for="text_color"><?=a($lang, 'Select text color')?></label>
				<input type="color" id="text_color" name="text_color" value="<?=a($handler->test, 'text_color')?>">
			</div>
			<div>
				<label for="bg_alpha"><?=a($lang, 'Select background transparency')?> <span id="bg_alpha_dv">(<?=intval(a($handler->test, 'bg_alpha')) / 100 ?>)</span></label>
				<input type="range" id="bg_alpha" name="bg_alpha" value="<?=a($handler->test, 'bg_alpha')?>" min="0", max="100">
			</div>
			<div>
				<input type="checkbox" id="is_text_border_on" name="is_text_border_on" value="1" <?=(intval(a($handler->test, 'is_text_border_on')) ? 'checked="checked"' : '')  ?>>
				<label for="is_text_border_on"><?=a($lang, 'Show text border')?></label>
			</div>
			<div>
				<label for="text_border_color"><?=a($lang, 'Select border text color')?></label>
				<input type="color" id="text_border_color" name="text_border_color" value="<?=a($handler->test, 'text_border_color')?>">
			</div>
		</div>
		<?php endif ?>
		
		<div class="right">
			<?php if (a($handler->test, 'id') ): ?>
			<?=FV::hid("action", "update"); ?>
			<?=FV::hid('id')?>
			<?=FV::sub('save_metadata', $lang['Save']); ?>
			<?=FV::sub('save_metadata_and_get_questions', $lang['Save_and_get_questions']); ?>
			<?php else: ?>
				<?=FV::hid("action", "create"); ?>
				<?=FV::sub('next_step_1', $lang['Next']); ?>
			<?php endif?>
		</div>
		<div class="clearfix"></div>
	</form>

</div>
