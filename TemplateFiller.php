<?php
function FillTemplate(String $text, $translate) {
    if(!$translate) {
        $translate = [];
    }

    $translateTo = [];

    foreach($translate as $key => $value) {
        $translateTo["{\$".$key."}"] = $value;
    }

    return str_replace(array_keys($translateTo), $translateTo, $text);
}
?>