<?php
require('./vendor/autoload.php');


$slim = new Slim\App;

$slim->post('/calc', $download = function ($request, $response) {
    $keys = $request->getParsedBody();
    $target = $request->getParsedBody()['target'];
    $arr_size = $request->getParsedBody()['array_size'];
    $numbers = $request->getParsedBody()['numbers'];
   
    // if ( !$target || !$numbers || !$arr_size) {
    if (!array_key_exists("target", $keys) || !array_key_exists("array_size", $keys) || !array_key_exists("numbers", $keys)){   
        $data = array('error' => 'Please send all the required fields');
        $newResponse = $response->withJson($data, 401);
    } else {
        $data = array('result' => getResult($target, $arr_size, $numbers));
        $newResponse = $response->withJson($data, 201);
    }
    return $newResponse;
});

function getResult($t,$s,$n)
{
    $url = 'https://gp-task-algorithm.herokuapp.com/';

//create a new cURL resource
    $ch = curl_init($url);

//setup request to send json via POST
    $data = array(
        'i' => $n,
        'n' => $s,
        't' => $t
    );
    $payload = json_encode($data);

//attach encoded JSON string to the POST fields
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

//set the content type to application/json
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

//return response instead of outputting
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

//execute the POST request
    $result = curl_exec($ch);

//close cURL resource
    curl_close($ch);
    return json_decode( $result, true )['result'];
}

$slim->run();