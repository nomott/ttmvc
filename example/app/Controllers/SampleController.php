<?php
namespace example\Controllers;

use ttmvc\ttmvc;

class SampleController {
    public function home() {
        ttmvc::view('/sample/home.php');
    }

    public function home_post() {
        $name = $_POST['name'];
        $data = [
            'name' => $name
        ];

        ttmvc::view('/sample/home.php', $data);
    }

    public function product($param) {
        $data = [
            'product' => $param
        ];

        ttmvc::view('/sample/product.php', $data);
    }
}
