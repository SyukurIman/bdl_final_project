<?php

require_once __DIR__ . '/../src/function.php';
require_once __DIR__ . '/../controller/adminController.php';
require_once __DIR__ . '/../controller/donasiController.php';
require_once __DIR__ . '/../controller/paymentController.php';
include "../src/config_db.php";

$GLOBALS['db'] = new Database_conect();
$GLOBALS['db']->connect();

$GLOBALS['Donasi'] = new DonasiController($GLOBALS['db']);
$GLOBALS['Payment'] = new PaymentController($GLOBALS['db']);


// Default index page
router('GET', '^/$', function(){
    $AdminController = new AdminController();
    $AdminController->index();
});

router('GET', '^/payment$', function() {
    $Payment = new PaymentController($GLOBALS['db']);
    $Payment->index();
});

router('POST', '^/payment/get_data/$', function(){
    header('Content-Type: application/json');
    $data = $_POST['sql'];
    echo $GLOBALS['Payment']->data_payment($data);
});

router('GET', '^/payment/update/(?<id>\d+)$', function($params){
    $GLOBALS['Payment']->update($params['id']);
});

router('POST', '^/payment/filter/$', function(){
    header('Content-Type: application/json');
    $data = json_decode(file_get_contents('php://input'), true);
    echo $GLOBALS['Payment']->filters($data);
});
router('POST', '^/payment/top_donasi/$', function(){
    header('Content-Type: application/json');
    $data = json_decode(file_get_contents('php://input'), true);
    echo $GLOBALS['Payment']->topDonasi($data);
});

router('GET', '^/donasi$', function(){
    $GLOBALS['Donasi']->index();
});

router('GET', '^/donasi/create$', function(){
    $GLOBALS['Donasi']->create();
});

router('POST', '^/donasi/get_data/$', function(){
    header('Content-Type: application/json');
    $data = $_POST['sql'];
    echo $GLOBALS['Donasi']->data_donasi($data);
});

router('POST', '^/donasi/save_create/$', function(){
    header('Content-Type: application/json');
    echo $GLOBALS['Donasi']->save_create();
});

router('GET', '^/donasi/update/(?<id>\d+)$', function($params){
    $GLOBALS['Donasi']->update($params['id']);
});

router('POST', '^/donasi/save_update/$', function(){
    header('Content-Type: application/json');
    echo $GLOBALS['Donasi']->save_update();
});

router('POST', '^/donasi/delete/$', function(){
    header('Content-Type: application/json');
    $data = json_decode(file_get_contents('php://input'), true);
    echo $GLOBALS['Donasi']->delete($data);
});

router('POST', '^/donasi/filter/$', function(){
    header('Content-Type: application/json');
    $data = json_decode(file_get_contents('php://input'), true);
    echo $GLOBALS['Donasi']->filters($data);
});



header("HTTP/1.0 404 Not Found");
echo '404 Not Found';