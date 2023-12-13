<?php

require_once __DIR__ . '/../src/function.php';
require_once __DIR__ . '/../controller/adminController.php';
require_once __DIR__ . '/../controller/donasiController.php';
require_once __DIR__ . '/../controller/paymentController.php';
include "../src/config_db.php";

$GLOBALS['db'] = new Database_conect();
$GLOBALS['db']->connect();


// Default index page
router('GET', '^/$', function(){
    $AdminController = new AdminController();
    $AdminController->index();
});

router('GET', '^/payment$', function() {

    $Payment = new PaymentController($GLOBALS['db']);
    $Payment->index();
});

router('GET', '^/donasi$', function(){
    $Donasi = new DonasiController($GLOBALS['db']);
    $Donasi->index();
});

router('GET', '^/donasi/create$', function(){
    $Donasi = new DonasiController($GLOBALS['db']);
    $Donasi->create();
});

// GET request to /users
router('GET', '^/users$', function() {
    echo '<a href="users/1000">Show user: 1000</a>';
});

// With named parameters
router('GET', '^/users/(?<id>\d+)$', function($params) {
    echo "You selected User-ID: ";
    var_dump($params);
});

// POST request to /users
router('POST', '^/users$', function() {
    header('Content-Type: application/json');
    $data = json_decode(file_get_contents('php://input'), true);
    echo json_encode(['result' => $data]);
});

header("HTTP/1.0 404 Not Found");
echo '404 Not Found';