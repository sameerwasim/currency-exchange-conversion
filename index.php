<?php

header('Content-Type: application/json; charset=utf-8');

$rates = [];

if (isset($_GET['token'])) {
    require_once('./env.php');
    require_once('./dbFunctions.php');
    
    $token = $_GET['token'];
    $user = $database->select(['table' => 'user', 'where' => "token = '$token'"]);

    if (isset($user[0])) {
        if ($user[0]['hits'] > 0) {
            $from = $_GET['from']; $to = $_GET['to'];
            $rawRates = $database->select([ 'table' => 'rates' ]);
            foreach($rawRates as $key => $rate) {
                $rates[$rate['countryCode']] = $rate;
            }
            
            if (isset($from) && isset($to)) {
                 $valid = validParams($from, $to, $rates);

                 if ($valid) {
                    $rates = [ 'from' => $from, 'to' => $to, 'rate' => calculateFromToRate($rates[$from], $rates[$to]) ];
                 } else {
                    $rates['error'] = 'Invalid Parameters';
                 }

                hitMesured($database, $token);
            } elseif (!(isset($from) || isset($to))) {
                hitMesured($database, $token);
            } else {
                $rates['error'] = 'Invalid Parameters';
            }
        } else {
            $rates['error'] = 'Package Limit Reached';
        }
    } else {
        $rates['error'] = 'Invalid Token';
    }

} else {
    $rates['error'] = 'Invalid Token';
}

echo json_encode($rates);


function hitMesured($database, $token) {
    $database->custom("UPDATE `user` SET `hits` = hits - 1  WHERE token = '$token'");
    $database->insertTbl('hitRecord', ['ip', 'token'], [$database->getClientIp(), $token]);
}

function validParams($from, $to, $rates) {
  return (array_key_exists($from, $rates) && array_key_exists($to, $rates));  
}

function calculateFromToRate($from, $to) {
    $from = 1 / $from['rate'];
    $to = 1 / $to['rate'];

    return $to / $from;
}