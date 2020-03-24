<?php
require_once(__DIR__ . '/vendor/autoload.php');

use ttmvc\ttmvc;
ttmvc::setViewDir( __DIR__ . '/app/Views');

$called = ttmvc::route([
  '/' => [
    'get' => ['example\Controllers\SampleController', 'home'],
	'post' => ['example\Controllers\SampleController', 'home_post']
  ],
  '/product/([a-z0-9]*)/' => [
    'get' => ['example\Controllers\SampleController', 'product'],
  ]
]);

if (is_null($called)) {
  ttmvc::view('/not_found/404.php');
  http_response_code(404);
}
