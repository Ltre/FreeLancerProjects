<?php

class Admin extends Model {

    protected $table_name = 'admin';


    //获取登录态所需的key
    public function getLoginInfoKey(){
        $ckName = 'fuckYourAdmin';
        $lgk = $_COOKIE[$ckName];
        if (empty($lgk)) {
            $lgk = 'sb'.intval(microtime(1)*1000);
            setcookie($ckName, $lgk, 0, '/');
        }
        return $lgk;
    }


    //获取登录态
    public function getLoginInfoCache(){
        $lgk = $this->getLoginInfoKey();
        $lgInfo = $_SESSION[$lgk] ?: array();
        return $lgInfo;
    }


    //设置登录态
    public function setLoginInfoCache($adminId){
        $lgk = $this->getLoginInfoKey();
        $lgInfo = $this->getRawAdmin($adminId);
        $GLOBALS['controller']->lgInfo = $lgInfo;
        $_SESSION[$lgk] = $lgInfo;
    }


    //清除登录态
    public function delLoginInfoCache() {
        $lgk = $this->getLoginInfoKey();
        unset($_SESSION[$lgk]);
    }


    /**
     * 获取用户库的源数据
     */
    public function getRawAdmin($adminId){
        $admin = $this->find(array('admin_id' => $adminId)) ?: array();
        return $admin;
    }


    public function getSaltPassword($password){
        $salt = 'fuckYourSalt';
        return hash_hmac('sha1', $password, $salt);
    }

}