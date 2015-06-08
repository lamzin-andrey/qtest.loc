<div class="utframe">
	<div id="utMainTTHelloScreen">
		<div class="clearfix">&nbsp;</div>
		<div id="ut_title"><?=$handler->metadata['display_name']?></div>
                <div class="clearfix">&nbsp;</div>
		<div id="ut_short_desc"><?=$handler->metadata['short_desc']?></div>
		<div class="clearfix">&nbsp;</div>
		<div id="ut_StartButtonPlace">
                    <div id="ut_main_twaitQuestion" class="center">Загрузка вопросов...</div>
                    <button id="ut_main_tstartGame" class="hide">Пройти тест</button>
		</div>
	</div>
	<div id="utMainTTDonescreen" class="hide">
            <div class="clearfix">&nbsp;</div>
            <div id="ut_main_tSuccess" class="ut__box_shadow tnw_center tnw_done_msg">Правильно!</div>
            <div class="clearfix">&nbsp;</div>
            <div id="ut_main_tSuccessInfo" class="ut__box_shadow tnw_center tnw_done_msg hide">Не забывайте переодически проходить этот тест по мере чтения новых статей на symfony-gu.ru.</div>
	</div>
	<div id="utMainTTFailscreen" class="hide">
                <div id="ut_main_tErr">Ошибка!</div>
                <div id="righAnswer" class="">
                    <div id="ut_ral">Правильный ответ</div>
                    <div id="ut_main_tRa"></div>
                </div>
	</div>
	<div id="utMainTTPlayscreen" class="hide">
            <div class="clearfix">&nbsp;</div>
            <div id="ut_main_tquest" class="left">Вы находитесь в консоли linux в каталоге приложения симфони 2. Введите команду для генерации бандла с именем РуддщИгтвду</div>
            <div id="ut_textarea_wrapper" class="right" style="width:45%;">
                <textarea id="ut_main_tanswer" rows="15" style="width:99%;" ></textarea>
            </div>
            <div class="clearfix"></div>
            <div class="tright ut_buttons">
                <input type="button" id="ut_main_tOK" value="OK">
                {{INPUT_SKIP}}
            </div>
	</div>
</div>
