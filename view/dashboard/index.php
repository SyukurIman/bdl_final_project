<?php

$content = ($position == "Home") ? __DIR__.'/home.php' : __DIR__."/setting.php";
$script_file = __DIR__.'/script.php';

include __DIR__ .'/../layout/app.php';