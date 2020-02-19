<?php

require_once 'simple_html_dom.php';

$url='http://parser.valemak.com/html-dom-parser-quick-start';
//создаём новый объект
$html = new simple_html_dom();
//загружаем в него данные
 $html = file_get_html($url);

class Parse 
{
function getBrokenImage($html){
    $img=array();
 foreach($html->find('img') as $a){
 array_push($img,('img-'. $a->src.'<br>'));
 }
 return $img;
}
function getAllLinks($html){
    $href=array();
foreach($html->find('a') as $element) {
$href[]= 'href:'. $element->href. '<br>';
}
return $href;
}
//освобождаем ресурсы
}

$parse=new Parse;
$getBrokenImage=$parse->getBrokenImage($html);
print_r ($getBrokenImage);
$getAllLinks=$parse->getAllLinks($html);
print_r($getAllLinks);

$html->clear(); 
unset($html);
?> 