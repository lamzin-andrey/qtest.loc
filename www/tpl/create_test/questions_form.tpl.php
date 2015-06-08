<div class="questions">
    <label>Вопрос</label> <label>Ответ</label> 
    <?php for ($i = 0; $i < $handler->per_page; $i++) {?>
    <div class="question-area">
        <input type="hidden" data-ord="<?=$i?>" value="<?=(isset($handler->questions[$i]) ? $handler->questions[$i]['id'] : 0)?>">
        <textarea rows="5" class="left j-question question"><?=(isset($handler->questions[$i]) ? $handler->questions[$i]['question'] : '')?></textarea>
        <textarea rows="5" class="left j-answer answer"><?=(isset($handler->questions[$i]) ? $handler->questions[$i]['answer'] : '')?></textarea>
        <input class="question-save-button" type="button" value="<?=$lang['Save']?>">
        <input class="question-delete-button" type="button" value="<?=$lang['Delete']?>">
        <input class="question-up-button" type="button" value="///\\\">
        <input class="question-down-button" type="button" value="\\\///">
        <div class="clearfix"></div>
    </div>
    <?php }?>
    <?=FV::but('addNewQuest', $lang['Add'])?>
</div>