<?php

namespace server\type;

/**
 * Description of baseType
 *
 * @author Administrator
 */
abstract class base {

    public abstract function sendMsg($context, $user, $msg);
}
