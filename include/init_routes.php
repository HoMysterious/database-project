<?php

/*
 * Source: http://blogs.shephertz.com/2014/05/21/how-to-implement-url-routing-in-php/
 *
 * ****************************************************************************************************************
 * The following function will strip the script name from URL
 * i.e.  http://www.something.com/search/book/fitzgerald will become /search/book/fitzgerald
*/

$basepath = implode('/', array_slice(explode('/', $_SERVER['SCRIPT_NAME']), 0, -1)) . '/';
$uri = substr($_SERVER['REQUEST_URI'], strlen($basepath));
$paramsx = array();
if (strstr($uri, '?')) {
    $paramsx = explode('&', substr($uri, strpos($uri, '?') + 1));
    $uri = substr($uri, 0, strpos($uri, '?'));
}
$uri = '/' . trim($uri, '/');

$routes = array();
$routesx = explode('/', $uri);
foreach ($routesx as $route) {
    if (trim($route) != '')
        array_push($routes, $route);
}

$params = array();
foreach ($paramsx as $param) {
    $p = explode('=', $param);
    $params[$p[0]] = isset($p[1]) ? $p[1] : null;
}

$GLOBALS['_ROUTES'] = $routes;
$GLOBALS['_PARAMS'] = $params;