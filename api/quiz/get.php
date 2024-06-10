<?php

function get($queryParams_a, $db_o) {

    /* $result_o = new stdClass();

    $result_o->{'result'} = 'ok'; */

    $result_o = json_decode(file_get_contents('./quiz.json'));
    
    return $result_o;
}