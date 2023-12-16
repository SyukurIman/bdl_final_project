<?php

$content = ($position == "Home") ? __DIR__.'/table.php': __DIR__.'/form.php';

$content = ($position == "Form Create") ? __DIR__.'/form_create.php' : $content;
$route_name = ($position == "Home") ? '' : ($position == "Form Create" ? '/payment/save_create/' : '/payment/save_update/');

$script_file = __DIR__.'/script.php';

include __DIR__ .'/../layout/app.php';