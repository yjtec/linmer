<?php

namespace server;

/**
 * Description of log
 *
 * @author Administrator
 */
class slog {

    public static function showLog($msg, $write = false) {
        echo date('Y-m-d H:i:s') . ' ' . $msg . PHP_EOL;
    }

}
