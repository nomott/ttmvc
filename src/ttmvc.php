<?php

namespace ttmvc;

/**
 * The single core class of ttmvc.
 */
class ttmvc {

    /**
     * View files' root directory.
     */
    private static $viewDir = '';
    private static function getViewDir() {
        return self::$viewDir;
    }
    public static function setViewDir($viewDir) {
        self::$viewDir = $viewDir;
    }

    /**
     * Find the specified route, run the specified action, and return the executed controller.
     */
    public static function route($route) {
        // Get relative URL from request URL.
        $baseUrl = dirname($_SERVER['SCRIPT_NAME']);
        $requestUrl = explode('?', $_SERVER['REQUEST_URI'])[0];
        $relativeUrl = $requestUrl;
        if ($baseUrl != '/') {
            $relativeUrl = str_replace($baseUrl, '', $requestUrl);
        }

        $patterns = array_keys($route);
        foreach ($patterns as $pattern) {
            
            $regex = '/^' . str_replace('/', '\/', $pattern) . '$/';
            $matches = [];
            
            // Check if the URL matches a defined pattern.
            if (!preg_match($regex, $relativeUrl, $matches)) {
                continue;
            }

            $params = [];
            if (count($matches) > 1) {
                array_splice($matches, 0, 1);
                $params = $matches;
            }
            
            // Check if action is defined for the http method.
            $config = array_change_key_case($route[$pattern], CASE_UPPER);
            $method = self::getHttpMethod();

            if (!empty($config[$method])) {
                // If there is a match, do the action.
                $target = $config[$method];

                if (is_callable($target)) {
                    if (is_array($target) && count($target) === 2) {
                        $c = $target[0];
                        $f = $target[1];
                        $obj = new $c();
                        call_user_func_array([$obj, $f], $params);
                        return $obj;
                    }

                    $target($params);
                    return $target;
                }
            }

            // If no action is defined, return null.
            return null;
        }

        // If no pattern is matched, return null.
        return null;
    }

    /**
     * Include the specified view file and unpack the parameter.
     */
    public static function view($viewName, $data = null) {
        $base = self::getViewDir();
        if (!empty($base)) {
            $base = rtrim($base, '/') . '/';
        }
        $viewName = ltrim($viewName, '/');

        $path = $base . $viewName;

        if (!file_exists($path)) {
            throw new \InvalidArgumentException("View file [$path] is not found.");
        }
    
        if (is_array($data)) {
            extract($data, EXTR_OVERWRITE);
        }
    
        include($path);
    }

    /**
     * Get the http request method.
     */
    public static function getHttpMethod() {
        return $_SERVER['REQUEST_METHOD'];
    }
}
