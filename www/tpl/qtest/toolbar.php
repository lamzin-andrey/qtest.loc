<ul class="inline left">
    <li>
        <a href="<?=WEB_ROOT?>/" title="<?=$lang['Exit_from_test']?>" alt="<?=$lang['Exit_from_test']?>">
            <?=H::img(WEB_ROOT . '/img/qtest/exit.png', $lang['Exit_from_test']);?>
        </a>
    </li>
</ul>
<div class="right">
	<ul class="inline">
            <li>
                <span>
                    <?=H::img(WEB_ROOT . '/img/qtest/clock.png', $lang['About_author'], array('style' => 'width:24px; height:24px; vertical-align:top;'));?>
                    <i id="ut_main_ttime_left">60</i> <?=$lang['sec.']?>
                </span>
            </li>
            <li>
                <span>
                    <?=H::img(WEB_ROOT . '/img/qtest/lives.png', $lang['About_author'], array('style' => 'width:24px; height:24px; vertical-align:top;'));?>
                    x <i id="ut_main_tlives">0</i>
                </span>
            </li>
            <li>
                <span>
                    <?=H::img(WEB_ROOT . '/img/qtest/star.png', $lang['Balls'], array('style' => 'width:24px; height:24px; vertical-align:top;'));?>
                    0
                </span>
            </li>
            <li>
                <a href="<?=WEB_ROOT?>/test_comments/<?=$handler->metadata['id']?>/">
                    <?=H::img(WEB_ROOT . '/img/std/user_say.png', $lang['Talk_about'], array('style' => 'width:24px; height:24px; vertical-align:top;'));?>
                </a>
            </li>
            <li>
                <a href="<?=WEB_ROOT?>/users/<?=$handler->metadata['uid']?>/">
                    <?=H::img(WEB_ROOT . '/img/qtest/userinfo_4801.png', $lang['About_author'], array('style' => 'width:24px; height:24px; vertical-align:top;'));?>
                    <?=$handler->metadata['user_name'] . ' ' . $handler->metadata['user_last_name']?>
                </a>
            </li>
	</ul>
</div>
<div class="clearfix"></div>
