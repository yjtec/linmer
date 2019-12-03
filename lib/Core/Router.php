<?php

namespace lib\Core;

use Exception;

/**
 * 路由，Router::get(正则，匹配的类，类的方法，预调用函数);
 *
 * @author Administrator
 */
class Router {

    const supportRequestType = ['get', 'post', 'cli'];

    public static $Routers = array(); //所有的路由,get路由,post路由,cli路由
    public static $CurRouter = array();
    public static $swoole_request;

    /**
     * 一个router的标准样子，array[类，方法，参数]，其中方法和参数可以为空
     * @return type
     */
    public static function getCLS() {
        $requestType = self::requestType();
        $requestUri = self::requestUri();
        self::$CurRouter = [];
        if (isset(self::$Routers[$requestType]) && self::$Routers[$requestType]) {
            foreach (self::$Routers[$requestType] as $route => $class_function) {
                if (preg_match($route, $requestUri, $matches)) {
                    self::$CurRouter = [$class_function[0], $class_function[1], self::getParam($matches, $requestType)];
                    break;
                }
            }
        }
        return self::$CurRouter;
    }

    public static function requestType() {
        if (isset(Core::$swoole_request->server['request_method']) && Core::$swoole_request->server['request_method']) {
            return strtolower(Core::$swoole_request->server["request_method"]);
        } else {
            return 'cli';
        }
    }

    public static function requestUri() {
        if (isset(Core::$swoole_request->server['request_uri']) && Core::$swoole_request->server['request_uri']) {
            return Core::$swoole_request->server["request_uri"];
        } else {
            return isset($_SERVER['argv'][1]) ? $_SERVER['argv'][1] : null;
        }
    }

    public static function getParam($matches, $requestType) {
        $param = [];
        switch ($requestType) {
            case 'cli':
                $param = [$_SERVER['argv']];
                break;
            case 'post':
                $param = [self::$swoole_request->post];
                break;
            case 'get':
            default :
                unset($matches[0]);
                $param = array_values(str_replace('/', '', $matches));
        }
        return $param;
    }

/////////////////////////////以下方法为设置路由/////////////////////////////
    private static function setRoute($type, $route, $class, $function = '') {
        self::$Routers[$type][$route] = [$class, $function];
    }

    public static function __callStatic($name, $arguments) {
        $func = strtolower($name);
        if (in_array($func, self::supportRequestType)) {
            if (!isset($arguments[0]) || !isset($arguments[1])) {
                return false;
            }
            if (isset($arguments[3]) && is_callable($arguments[3])) {
                $arguments[3]();
            }
            self::setRoute($func, $arguments[0], $arguments[1], isset($arguments[2]) && $arguments[2] ? $arguments[2] : '');
        } else {
            throw new Exception('不支持的请求类型');
        }
    }

}
