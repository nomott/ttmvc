<?php

namespace ttmvc\Tests;

require_once( __DIR__ . '/../vendor/autoload.php' );

use ttmvc\ttmvc;
use PHPUnit\Framework\TestCase;
use ttmvc\Tests\Controllers\MockController;

class ttmvcTest extends TestCase {
    
    public function setUp(): void {
    }

    public function tearDown(): void {
        ttmvc::setViewDir('');
    }

    private function setUrl() {
        $_SERVER['SCRIPT_NAME'] = '/ttmvc/unittest/testurl/index.php';
        $_SERVER['REQUEST_URI'] = '/ttmvc/unittest/testurl/testcase/';
        $_SERVER['REQUEST_METHOD'] = 'GET';
    }

    private function setUrlWithParam() {
        $_SERVER['SCRIPT_NAME'] = '/ttmvc/unittest/testurl/index.php';
        $_SERVER['REQUEST_URI'] = '/ttmvc/unittest/testurl/testcase/101/';
        $_SERVER['REQUEST_METHOD'] = 'GET';
    }



    /**
     * Test cases for route()
     */

    public function testRouteMatchedUrlDoAction() {
        $this->setUrl();

        $c = ttmvc::route([
            '/testcase/' => [
                'get' => ['ttmvc\Tests\Controllers\MockController', 'testAction1']
            ],
        ]);
        
        $this->assertInstanceOf('ttmvc\Tests\Controllers\MockController', $c);
        $this->assertSame(true, $c->isCalled('testAction1'));
    }

    public function testRouteMatchedUrlDoActionCallable() {
        $this->setUrl();
        $c = new MockController();

        ttmvc::route([
            '/testcase/' => [
                'get' => function() use ($c) { $c->testAction1(); }
            ],
        ]);
        
        $this->assertInstanceOf('ttmvc\Tests\Controllers\MockController', $c);
        $this->assertSame(true, $c->isCalled('testAction1'));
    }

    public function testRouteMatchedUrlDoActionWithParam() {
        $this->setUrlWithParam();

        $c = ttmvc::route([
            '/testcase/([0-9]{3})/' => [
                'get' => ['ttmvc\Tests\Controllers\MockController', 'testAction2']
            ],
        ]);
        
        $this->assertInstanceOf('ttmvc\Tests\Controllers\MockController', $c);
        $this->assertSame(true, $c->isCalled('testAction2', '101'));
    }

    public function testRouteNoActionReturn404() {
        $this->setUrl();

        $result = ttmvc::route([
            '/testcase/' => [
                'get' => ['ttmvc\Tests\Controllers\MockController', 'invalid_action']
            ],
        ]);
        
        $this->assertNull($result);
    }

    public function testRouteNoMatchedUrlReturn404() {
        $this->setUrl();

        $result = ttmvc::route([
            '/invalid_rule/' => [
                'get' => ['ttmvc\Tests\Controllers\MockController', 'testAction1']
            ],
        ]);
        
        $this->assertNull($result);
    }


    
    /**
     * Test cases for view()
     */

     public function testViewIncludeFile() {
         ttmvc::setViewDir(__DIR__);

         ob_start();
         ttmvc::view('/Views/testview.php');
         $actual = ob_get_contents();
         ob_end_clean();

         $expected = '<html><body><h1>Unit Test </h1></body></html>';
         $this->assertSame($expected, $actual);
     }
     
     public function testViewIncludeFileFullPath() {
        ob_start();
        ttmvc::view(__DIR__ . '/Views/testview.php');
        $actual = ob_get_contents();
        ob_end_clean();

        $expected = '<html><body><h1>Unit Test </h1></body></html>';
        $this->assertSame($expected, $actual);
    }

    public function testViewIncludeFileWithParams() {
        ttmvc::setViewDir(__DIR__);

        ob_start();
        ttmvc::view('/Views/testview.php', ['testVar' => 'testValue']);
        $actual = ob_get_contents();
        ob_end_clean();

        $expected = '<html><body><h1>Unit Test testValue</h1></body></html>';
        $this->assertSame($expected, $actual);
    }

    public function testViewInvalidFileNameThrowsException() {
        ttmvc::setViewDir(__DIR__);
        $actual = new \Exception();

        try {
            ttmvc::view('/invalid_file.php');
        }
        catch(\Exception $e) {
            $actual = $e;
        }

        $expected = "View file [" . __DIR__ . "/invalid_file.php] is not found.";
        $this->assertSame($actual->getMessage(), $expected);
    }
}
