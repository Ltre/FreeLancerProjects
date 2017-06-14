<?php

class Rootist extends Model {
    
    protected $table_name = 'rootist';

    function append($adminId = 0){
        $url = $_SERVER['HTTP_REFERER'] ?: '';
        $this->insert(array(
            'ip' => getIP(),
            'vtime' => time(),
            'admin_id' => $adminId,
            'url' => $url,
        ));
    }

}