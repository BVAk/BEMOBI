<?php
require_once 'simple_html_dom.php';

class Parse
{
    function getBrokenImage($url)
    {
        $img = array();
        $img2 = array();
        $data = file_get_html($url);
        if (count($data->find('img'))) {
            foreach ($data->find('img') as $a) {
                $header_response = get_headers($a->src, 1);
                if (strpos($header_response[0], "404") !== false) {
                    array_push($img, ($a->src . '<br>'));
                    // FILE DOES NOT EXIST
                } else {
                    array_push($img2, ($a->src . '<br>'));
                }
            }
        }
        if (empty($img)) {
            echo ("Все картинки на странице загрузились.<br>");
            echo ("Картинки, которые загрузились на странице.<br>"); print_r($img2);
            echo ("<br>");
        } else { echo ("Картинки, которые на странице не загрузились.<br>");
            print_r($img);
            echo ("<br>");}
        $data->clear(); // подчищаем за собой
        unset($data);
    }

    function getAllLinks($url)
    {
        $html = file_get_html($url);
        $href = array();
        foreach ($html->find('a') as $element) {
            if (strpos($element->href, 'www') !== false) {
                if (strpos($element->href, 'http') !== false) {
                    array_push($href, ('<a href="' . $element->href . '">' . $element->href . '</a></br>'));
                } else {
                    array_push($href, ('<a href="https://' . $element->href . '">https:' . $element->href . '</a></br>'));
                }
            } elseif (strpos($element->href, 'http') !== false) {
                array_push($href, ('<a href="' . $element->href . '">' . $element->href . '</a></br>'));
            } else {
                array_push($href, ('<a href="' . $url . $element->href . '">' . $url . $element->href . '</a></br>'));
            }
        }
        if (empty($href)) {
         echo ("Ссылки не найдены.<br>");
        }
        else{ echo ("Ссылки:.<br>");
            print_r($href);
            echo ("<br>");}

        $html->clear();
        unset($html);
    }
    //освобождаем ресурсы
}

$parse = new Parse;
$url = 'http://localhost/bemobi/index.html';
$getBrokenImage = $parse->getBrokenImage($url);
$getAllLinks = $parse->getAllLinks($url);
