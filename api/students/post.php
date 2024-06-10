<?php

function post($payload_a, $db_o) {

    $response_o = new stdClass();

    $statusCode_i = null;

    $missingParametersInPayload_s = checkForMissingParametersInPayload($payload_a);

    if($missingParametersInPayload_s) {

        $statusCode_i = 422;

        $response_o->{'error'} = createErrorObject($statusCode_i, 'Missing parameters in payload: ' . $missingParametersInPayload_s);
    }

    if(!$statusCode_i) {

        $studentAlreadyExists_b = checkIfStudentAlreadyExists($payload_a, $db_o);

        if($studentAlreadyExists_b) {

            $statusCode_i = 409;

            $response_o->{'error'} = createErrorObject($statusCode_i, 'Student account already exists');
        }
    }

    if(!$statusCode_i) {

        $statusCode_i = 201;

        $response_o->{'data'} = createStudent($payload_a, $db_o);
    }

    http_response_code($statusCode_i);
    
    return $response_o;
}

function checkForMissingParametersInPayload($payload_a) {

    $missingParametersInPayload_a = [];

    if(empty($payload_a['email'])) {

        array_push($missingParametersInPayload_a, 'email');
    }

    if(empty($payload_a['firstname'])) {

        array_push($missingParametersInPayload_a, 'firstname');
    }

    if(empty($payload_a['lastname'])) {

        array_push($missingParametersInPayload_a, 'lastname');
    }

    if(empty($payload_a['password'])) {

        array_push($missingParametersInPayload_a, 'password');
    }

    $missingParametersInPayload_s = implode(', ', $missingParametersInPayload_a);
    
    return $missingParametersInPayload_s;
}

function checkIfStudentAlreadyExists($payload_a, $db_o) {

    $params_a = [
        'email' => $payload_a['email'] 
    ];

    $dbQueryResult_o = $db_o->select('student', $params_a);

    $studentAlreadyExists_b = sizeof($dbQueryResult_o->{'data'}) > 0;

    return $studentAlreadyExists_b;
}

function createErrorObject($statusCode_i, $errorMessage_s) {

    $error_o = new stdClass();

    $error_o->{'code'} = $statusCode_i;

    $error_o->{'message'} = $errorMessage_s;

    return $error_o;
}

function createStudent($payload_a, $db_o) {

    $params_a = [
        'firstname' => $payload_a['firstname'],
        'lastname' => $payload_a['lastname'],
        'email' => $payload_a['email'],
        'password' => $payload_a['password']
    ];

    $dbQueryResult_o = $db_o->insertInto('student', $params_a);

    $data_o = new stdClass();

    $data_o->{'id'} = $dbQueryResult_o->{'data'}->{'id'};

    return $data_o;
}