<?php

namespace ttmvc\Tests\Controllers;

class MockController {
    private $calledMethods = [];

    public function isCalled($name, $args = null) {
        if (!isset($this->calledMethods[$name])) {
            return false;
        }

        return $this->calledMethods[$name]['args'] === $args;
    }

    public function testAction1() {
        $this->calledMethods[__FUNCTION__] = ['name' => __FUNCTION__, 'args' => null];
    }

    public function testAction2($id) {
        $this->calledMethods[__FUNCTION__] = ['name' => __FUNCTION__, 'args' => $id];
    }
}
