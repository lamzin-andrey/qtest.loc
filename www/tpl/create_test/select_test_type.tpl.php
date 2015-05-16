<?php
/*Шаблон в /opt/lampp/htdocs/qtest.loc/www/files/tpl/js/template/*/
?><div class="promo">
	<header>
		<h2><?=$lang['Test_titles'] ?></h2>
	</header>
	<form method="GET" action="<?=WEB_ROOT?>/create_test/set_name" >
		<? FV::$obj = $handler; ?>
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
			<?=FV::text('test_description', 15, array('class' => 'test_description')) ?>
		</div>
		<div class="create_test_info">
			<label class="block" for="info"><?php echo $lang["create_test_info"]; ?></label>
			<div class="create_test_comment"><?php echo $lang["create_test_info_comment"];?></div>
			<?=FV::text('info', 10, array('class' => 'test_info')) ?>
		</div>
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
		<header>
			<h2><?php echo $lang['Test_times']?></h2>
		</header>
		<div class="create_test_seconds">
			<div><?=FV::labinp('time_decision', $lang['time_wait_answer'], 60, 0, 'number');?> <?=$lang['sec.'] ?></div>
			<div><?=FV::labinp('time_show_error_message', $lang['time_show_error_message'], 5, 0, 'number');?> <?=$lang['sec.'] ?></div>
			<div><?=FV::labinp('time_show_success_message', $lang['time_show_success_message'], 3, 0, 'number');?> <?=$lang['sec.'] ?></div>
			<div><?=FV::labinp('time_show_game_over_message', $lang['time_show_game_over_message'], 5, 0, 'number');?> <?=$lang['sec.'] ?></div>
			<div><?=FV::labinp('time_show_win_screen', $lang['time_show_win_screen'], 15, 0, 'number');?> <?=$lang['sec.'] ?></div>
		</div>
		<header>
			<h2><?php echo $lang['Test_any_params']?></h2>
		</header>
		<div class="create_test_cb"><?=FV::checkbox('is_random', $lang['Test_is_random']) ?></div>
		<div class="create_test_score"><?=FV::labinp('test_score', $lang['Test_score'], 5, 0, 'number'); ?></div>
		<div class="create_test_lives"><?=FV::labinp('test_lives', $lang['Test_lives'], 2, 0, 'number'); ?></div>
		<div class="create_test_cb"><?=FV::checkbox('is_skip', $lang['Test_is_skip']) ?></div>
		<div id="skip_params">
			<div class="create_test_skip_score"><?=FV::labinp('test_skip_score', $lang['Test_skip_price'], 1, 0, 'number'); ?></div>
			<div class="create_test_skip_border"><?=FV::labinp('test_skip_border', $lang['Test_skip_border'], 0, 0, 'number'); ?></div>
		</div>
		<div class="create_test_cb"><?=FV::checkbox('show_answer', $lang['Test_show_answer']) ?></div>
		<div class="create_test_skip_success_message"><?=FV::labinp('one_answer_success_message', $lang['Test_one_answer_success_message'], $lang['ctest_v_is_right']); ?></div>
		<div class="create_test_skip_error_message"><?=FV::labinp('one_answer_fail_message', $lang['Test_one_answer_fail_message'], $lang['ctest_v_is_fail']); ?></div>
		<div class="create_test_skip_gameover_message"><?=FV::labinp('gameover_message', $lang['Test_game_over_message'], $lang['GAME_OVER']); ?></div>
		<div class="right">
			<?=FV::sub('next_step_1', $lang['Next']); ?>
		</div>
		<div class="clearfix"></div>
	</form>

</div>
