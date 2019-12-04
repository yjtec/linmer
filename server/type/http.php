<?php

namespace server\type;

/**
 * Description of http
 *
 * @author Administrator
 */
class http extends base {

    public $uni;

    public function req($request, $response) {
        echo "http." . PHP_EOL;
        $this->uni->Msg = $request->get;
        $msg = $this->uni->doMsg();
        if (!$msg) {
            $msg = ['status' => $this->uni->errnum, 'msg' => $this->uni->errmsg];
        }
        $this->sendMsg($response, null, json_encode($msg));
    }

    public function sendMsg($response, $user, $msg) {
        $response->end($msg);
    }

}
