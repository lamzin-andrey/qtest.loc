<?php
/** @desc Функции исключительно для сайта quitest.ru */

/**
* @desc Создать файлы теста
* @param int $test_id
* @param assoc_array $data
* @param string $developer Если тест редактируется, можно создавать dev версию
*/
function createTestFiles($test_id, $data, $developer = '') {
   if ($data['t_type'] == 1) {
       $js = file_get_contents(APP_ROOT . '/files/tpl/js/text/3.2.js');
       $css = file_get_contents(APP_ROOT . '/files/tpl/js/text/3.2.css');
       $php = file_get_contents(APP_ROOT . '/files/tpl/js/text/3.2.tpl.php');
       $js = str_replace('{{TESTID}}', $test_id, $js);
       $data['is_random'] = a($data, 'is_random') ? $data['is_random'] : 0;
       $data['show_answer'] = a($data, 'show_answer') ? $data['show_answer'] : 0;
       if (ireq('is_skip') > 0) {
           $js = str_replace('{{SKIP_BORDER}}', file_get_contents(APP_ROOT . '/files/tpl/js/text/skip.tpl.part.js'), $js);
           $php = str_replace('{{INPUT_SKIP}}', file_get_contents(APP_ROOT . '/files/tpl/js/text/skip.tpl.part.php'), $php);
       } else {
           $js = str_replace('{{SKIP_BORDER}}', '', $js);
           $php = str_replace('{{INPUT_SKIP}}', '', $php);
       }
       if (ireq('t_compare') == 0) {
           $js = str_replace('{{COMPARE_TYPE}}', file_get_contents(APP_ROOT . '/files/tpl/js/text/compare.tpl.part.js'), $js);
       } else {
           $js = str_replace('{{COMPARE_TYPE}}', '', $js);
       }
       if (ireq('show_answer') > 0) {
           $php = str_replace('{{RIGHT_ANSWER}}', file_get_contents(APP_ROOT . '/files/tpl/js/text/ra.tpl.part.php'), $php);
       } {
           $php = str_replace('{{RIGHT_ANSWER}}', '', $php);
       }
       
       $css = str_replace('/** custom_bg */', _cssBg($data['bgimage']), $css);
       $css = str_replace('/** text_color */', _cssTextColor($data['text_color']), $css);
       
       foreach ($data as $key => $item) {
           if (strpos($key, '_message') === false) {
               $item = (int)$item;
           } else {
               db_safeString($item);
           }
           $js = str_replace('{{'. $key .'}}', $item, $js);
           $php = str_replace('{{'. $key .'}}', $item, $php);
       }
       file_put_contents(APP_ROOT . '/files/' . $data['folder'] . '/' . $data['uid'] . '.' . $developer . $test_id . '.js', $js);
       file_put_contents(APP_ROOT . '/files/' . $data['folder'] . '/' . $data['uid'] . '.' . $developer . $test_id . '.css', $css);
       file_put_contents(APP_ROOT . '/files/' . $data['folder'] . '/' . $data['uid'] . '.' . $developer . $test_id . '.tpl.php', $php);
   } else {
       die('До вариантов еще как до Китая');
   }
}
/**
 * @description  фоновое изображение и текст
*/
function _cssBg($sBgImage)
{
	$s = ".main {
		background-image: url('{$sBgImage}')!important;
	}";
	return $s;
}
/**
 * @description  Цвет текста в тесте
*/
function _cssTextColor($sTextColorValue)
{
	$s = "color: {$sTextColorValue};text-shadow: 1px 1px 0 black,0 0 1px {$sTextColorValue};
}";
	return $s;
}
