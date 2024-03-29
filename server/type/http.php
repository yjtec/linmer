<?php

namespace server\type;

use server\slog;

/**
 * Description of http
 *
 * @author Administrator
 */
class http extends base {

    public $uni;

    public function req($request, $response) {
        slog::showLog('收到http请求');
        $this->uni->Msg = $request->post;
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
