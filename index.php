<?php
require('./vendor/autoload.php');


$slim = new Slim\App;

$slim->post('/calc', $download = function ($request, $response) {
    $target = $request->getParsedBody()['target'];
    $arr_size = $request->getParsedBody()['array_size'];
    $numbers = $request->getParsedBody()['numbers'];
    echo $target;
    echo $numbers;
    echo $arr_size;

    if (!$target || !$numbers || !$arr_size) {
        $data = array('error' => 'Please send all the required fields');
        $newResponse = $response->withJson($data, 402);
    } else {
        $data = array('result' => getResult());
        $newResponse = $response->withJson($data, 201);
    }
    return $newResponse;
});

function getResult () {
    return 'hello world';
}

$slim->run();