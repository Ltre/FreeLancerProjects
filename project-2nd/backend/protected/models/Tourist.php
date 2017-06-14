<?php

class Tourist extends Model {
    
    protected $table_name = 'tourist';

    function append($uid = 0){
        $url = $_SERVER['HTTP_REFERER'] ?: '';
        if (! empty($url)) {
            $this->insert(array(
                'ip' => getIP(),
                'vtime' => time(),
                'uid' => $uid,
                'url' => $url,
                'cookie' => $this->getCookie(),
            ));
        }
    }

    protected function getCookie(){
        $ckName = 'fuckYourMum';
        if ($_COOKIE[$ckName]) {
            return $_COOKIE[$ckName];
        }
        $cookie = sha1(intval(microtime(1) * 1000).rand(0, 999));
        setcookie($ckName, $cookie, time() + 86400 * 30 * 12, '/');
        return $cookie;
    }

}