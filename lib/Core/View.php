<?php

namespace lib\Core;

use Exception;

/**
 * Description of View
 *
 * @author Administrator
 */
class View {

    /**
     * 模板输出变量
     * @var tVar
     * @access protected
     */
    protected static $tempVar = array();
    public static $baseDir;

    /**
     * 模板变量赋值
     * @access public
     * @param mixed $name
     * @param mixed $value
     */
    public static function take($name, $value = '') {
        if (is_array($name)) {
            self::$tempVar = array_merge(self::$tempVar, $name);
        } else {
            self::$tempVar[$name] = $value;
        }
    }

    /**
     * 取得模板变量的值
     * @access public
     * @param string $name
     * @return mixed
     */
    public static function get($name = '') {
        if ('' === $name) {
            return self::$tempVar;
        }
        return isset(self::$tempVar[$name]) ? self::$tempVar[$name] : false;
    }

    /**
     * 加载模板和页面输出 可以返回输出内容
     * @access public
     * @param string $templateFile 模板文件名
     * @param string $charset 模板输出字符集
     * @param string $contentType 输出类型
     * @param string $content 模板输出内容
     * @param string $prefix 模板缓存前缀
     * @return mixed
     */
    public static function display($templateFile = '') {
        return self::getTempContent($templateFile);
    }

    /**
     * 解析和获取模板内容 用于输出
     * @access public
     * @param string $templateFile 模板文件名
     * @return string
     */
    public static function getTempContent($templateFile = '') {
        $templateFile = self::parseTemplate($templateFile);
        // 模板文件不存在直接返回
        if (!is_file($templateFile)) {
            throw new Exception('模板不存在' . $templateFile);
        }
        // 页面缓存
        ob_start();
        ob_implicit_flush(0);
        // 模板阵列变量分解成为独立变量
        extract(self::$tempVar, EXTR_OVERWRITE);
        // 直接载入PHP模板
        include $templateFile;
        // 获取并清空缓存
        $content = ob_get_clean();
        // 内容过滤标签
        // 输出模板文件
        return $content;
    }

    /**
     * 自动定位模板文件
     * @access protected
     * @param string $template 模板文件规则
     * @return string
     */
    public static function parseTemplate($template = '') {
        if (is_file($template)) {
            return $template;
        }
        return './' . ($template ? $template : self::getCallFunction()) . '.php';
    }

    private static function getCallFunction() {
        $call = [];
        $backtrace = debug_backtrace();
        foreach ($backtrace as $k => $b) {
            if (isset($b['class']) && isset($b['function']) && isset($b['type']) && $b['class'] == 'lib\\Core\\View' && $b['function'] == 'display' && $b['type'] == '::') {
                $call = $backtrace[$k + 1];
                break;
            }
        }
        if (isset($call['class']) && isset($call['function'])) {
            return str_replace('\\', '/', $call['class']) . '/' . $call['function'];
        }
        return null;
    }

}
