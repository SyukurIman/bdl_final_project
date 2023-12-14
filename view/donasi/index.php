<?php

$content = ($position == "Home") ? __DIR__.'/table.php': __DIR__.'/form.php';
$route_name = ($position == "Home") ? '' : ($position == "Form Create" ? ' ' : '/donasi/save_update/');

$script_file = __DIR__.'/script.php';

include __DIR__ .'/../layout/app.php';