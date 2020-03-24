# tiny tiny mvc framwork for php
-----

This is made when I was working for very small project and wanted a simple MVC framework.

## Quick Overview

Usage:
```
# /index.php

ttmvc::setViewDir( __DIR__ . '/Views';
$called = ttmvc::route([
  '/' => [
    'get' => ['MyController', 'home'],
	  'post' => ['MyController', 'home_post']
  ],
  '/product/([a-z0-9]*)/' => [
    'get' => ['MyController', 'product'],
  ]
]);

if (is_null($called)) {
  echo '404 Not Found';
  http_response_code(404);
}
```

```
# /Controllers/MyController.php

class MyController {
  public function home() {
    ttmvc::view('/home.php');
  }
  
  public funciton home_post() {
    $name = $_POST['name'} ?? '';
    $data = ['name' => $name];
	
    ttmvc::view('/home.php', $data);
  }
  
  public function product($product) {
    $data = ['product' => $product];
    ttmvc::view('/home.php', $data);
  }
}
```

```
# /Views/home.php

<html>
  <body>
    <p>Name: <?= $name ?? 'No parameter [name] is passed.'; ?></p>
    <p>Product: <?= $product ?? 'No parameter [product] is passed.'; ?></p>
  </body>
</html>
```


## Details

The framework only contains 2 functions: **route()** and **view()**.


### route() function

This function is the entry point of the application and should be called in the front controller.  
The function takes one parameter, *route configuration*, that specify how the request should be routed to controller actions.

The structure of *route configuration* is straight forward. It is consisted of URL path, HTTP method, Controller class, and Action name, where Action name is the name of a method in the Controller class.

You can also pass parameters to action methods.  
This library just uses *preg_match()* to see if the request url matches to the route configuraiton, and if it captured matches, it will pass the matched values to the action method.


#### Example 1: Basic
```
ttmvc::route([
  '/' => [
    'get' => ['MyController', 'index'],
    'post' => ['MyController', 'index_post']
  ]
]);
```
When accessing document root *("/")* with *"get"* http method, this code will call *index()* method in the *MyController* class.


#### Example 2: Passing parameter in the URL path.

```
ttmvc::route([
  '/product/([a-z0-9]*)/ => [
    'get' => ['MyController', 'product']
  ]
]);
```
When accessing */product/example123* with *get* method, this code will call *product()* method in *MyController* class with a parameter *"example123"*.


### view() function

The other function in the framework is view(). This function takes 2 parameters, *view file name* and *view parameter*.

Usage:
```
ttmvc::view('/path/to/view/file', $parameterArray);
```

#### view file name

View file can be any file, such as .php or .html or anything. view() function just include the specified file, and the file path can be specified with either absolute path or relative path.  
When specifying a relative path, you must call ttmvc::setViewDir("/path/to/view/dir/") to set the view files' root directory.

#### view parameter

View parameter is an array, and its keys will be expanded to variables.  
For example, if you pass array('foo' => 'bar') to the view file, the value "bar" can be accessed by $foo variable.


#### Example: Passing values to view file.
```
# MyController.php

class MyController {
  public function example() {
    $data = [
      'foo' => 'bar'
    ];

    ttmvc::view('/example.php', $data);
  }
}
```

```
# /example.php
<html>
  <body>
    <p>Below code will print "bar".</p>
    <p><?= $foo; ?></p>
  </body>
</html>
```
