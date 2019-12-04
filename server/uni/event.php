<?php

namespace server\uni;

/**
 * Description of event
 *
 * @author Administrator
 */
abstract class event {

    public $errmsg;
    public $errnum;

    public abstract function run();

    public abstract function checkMsg($msg);
}
