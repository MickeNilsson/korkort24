<?php

function callEndpoint($endpoint_s) {

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
    header('Content-Type: application/json; charset=utf-8');

    require_once __DIR__ . '/db.php';

    $settings_a = [
        'host'         => 'mysql14.unoeuro.com',
        'db'           => 'mikael_nilsson_se_db',
        'user'         => 'mikael_nilsson_se',
        'password'     => '6RfaxEbrDmt3',
        'charset'      => 'utf8mb4'
    ];

    $db_o = new DB($settings_a);

    switch($_SERVER['REQUEST_METHOD']) {

        case 'GET':
    
            require_once __DIR__ . '/' . $endpoint_s . '/get.php';
            
            $result_o = get($_GET, $db_o);
            
            break;
            
        case 'POST':
    
            require_once __DIR__ . '/' . $endpoint_s . '/post.php';
            $payload_s = file_get_contents('php://input');
            $payload_o = json_decode($payload_s);
            $result_o = post($payload_o, $db_o);
            break;
    
        case 'PUT':
    
            require_once './' . $endpoint_s . '/put.php';
            $response_s = post();
            break;
    }
    
    $result_s = json_encode($result_o, JSON_UNESCAPED_UNICODE);
    
    echo $result_s;
}




