<div class="user_test_list">
    <?php if ($handler->tests > 0):?>
    <?php foreach ($handler->tests as $test):?>
    <div class="test_info">
        <div class="left test-left">
            <h4><heading><?=$test['display_name']?></heading></h4>
            <span><?=$test['short_desc']?></span>
        </div>
        <div class="left">
            <div class="<?=($test['t_type'] == 1 ? 'test-state-div' : 'test-state-div')?>">
                <?=($test['t_type'] == 1 ? $lang['Test_is_text'] : $lang['Test_is_variants'])?>
            </div>
            <div class="<?=($test['is_accepted'] ? 'bg-light-green test-state-div' : 'bg-rose test-state-div')?>">
                <?=($test['is_accepted'] ? $lang['Accepted_moderator'] : $lang['Not_accepted_moderator'])?>
            </div>
            <div class="<?=($test['is_published'] ? 'bg-light-green test-state-div' : 'bg-rose test-state-div')?>">
                <?=($test['is_published'] ? $lang['Is_publish'] : $lang['Not_publish'])?>
            </div>
        </div>
        <div class="left dbg">
            <?=H::a(WEB_ROOT . '/my/' . $test['id'], H::img(WEB_ROOT . '/images/img/qtest/edit_test.png', $lang['Edit']))?>
            <?=H::a(WEB_ROOT . '/create_test/' . $test['id'] . '/questions', H::img(WEB_ROOT . '/images/img/qtest/edit_questions_test.png', $lang['Edit_questions']) )?>
            <?=H::a(WEB_ROOT . '/tests/' . $test['reading_uri'], H::img(WEB_ROOT . '/images/img/qtest/exec_test.png', $lang['Open_test']), '', true )?>
        </div>
        <div class="clearfix"></div>
    </div>
    <?php endforeach?>
    <?php else:?>
    <?=H::info($lang['You_has_not_tests_now'])?>
    <?php endif ?>
</div>