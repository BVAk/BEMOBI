<?php

declare(strict_types=1);

interface IUrlChecker
{

    public function getBrokenImage($url): array;
    public function getAllLinks($url): array;
}

include './simple_html_dom.php';

final class Parser implements IUrlChecker
{

    public function getBrokenImage($url): array
    {
        $img = array();
        $data = file_get_html($url);
        if (count($data->find('img'))) {
            foreach ($data->find('img') as $a) {
                $header_response = get_headers($a->src, 1);
                if (strpos($header_response[0], "404") !== false) {
                    array_push($img, ($a->src . '<br>'));
                    // FILE DOES NOT EXIST
                } else {
                    array_push($img, ("Все картинки на странице загрузились.<br>"));
                }
            }
        }

        $data->clear();
        unset($data);
        return $img;
    }

    public function getAllLinks($url): array
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

        $html->clear();
        unset($html);
        return $href;
    }
}
