<?php

namespace lib;

use cfg\Conf;
use Yjtec\Linmodel\Model;

/**
 * Description of baseMd
 *
 * @author Administrator
 */
class baseMd extends Model {

    public function __construct($config = null) {
        parent::__construct($config ? $config : Conf::DB_CNF);
    }

    public function getById($id) {
        if (!$id) {
            return [];
        }
        return $this->where(['id' => $id])->select(TRUE);
    }

    public function updataFieldVal($id, $data) {
        return $this->where(['id' => $id])->update($data);
    }

}
