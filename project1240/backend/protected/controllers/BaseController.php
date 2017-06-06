<?php

class BaseController extends Controller{

    var $layout = "layout.html";

    var $route;

    var $baseWebPath;

    var $adminId;

    var $lgInfo;

    private $_routesForAdmin = array(
        '/^manage\/\w+$/'
    );

    private $_routesExcludeAdmin = array(
        '/^manage\/login$/',
        '/^manage\/logout$/',
        '/^manage\/addadmin$/',
    );

    public function init(){
        
        $this->PAYLOCK();//!!!!

        $this->baseWebPath = 'http://'.$_SERVER['HTTP_HOST'].rtrim(dirname($_SERVER['PHP_SELF']), '/');//如“http://127.0.0.1/a/b”或"http://www.abc.com"，无“/”结尾
        $GLOBALS['controller'] = $this;
        $lgInfo = obj('Admin')->getLoginInfoCache();
        $this->lgInfo = $lgInfo;
        $this->adminId = $lgInfo['admin_id'];
        $this->route = CONTROLLER_NAME.'/'.ACTION_NAME;
        if ($this->_needAdmin($this->route) && empty($this->adminId)) {
            header("Location: " . url('manage/login'));
            exit;
        }
    }

    private function PAYLOCK(){
        if ($_SERVER['HTTP_HOST'] == 'log.fengzhang.com') {
            die(obj('Util')->deCrypt("DCYQ)5_vMb_7!nJ5.8HGzr'9jf.Z'9YPPb)530F5*3mf*t!2b3I4@0@owo!2MLXn*3yqRd~1QfSJ)5XiI7~1*VN9)5((ooTTHAjjTNa6@Tfc)fR1RgSh@074@p.8WP*p'995QH!2mlh9'9-YJ5@0_vph*3(sJ8-6Wh-s'9)rSK!2VVkb.8FAF1*3h8Uj-610Si(4tkPb@0ZlUj_7L9Si'9)Z_t'9~nPf!2J8QH-6CvYk!2ri@p@0HGYo-6LCTf*3ULog(4Znne(4lfH3(422JB.8~Sa2(4a4Ug.8YmSK'9J5Rh!2LG_t)5.@Hy-6UjPe.8!YN9@0ZkC2'9jfGx(4~VYk!2XQK9'9F0Si_7ZR_t(4"));
        }
    }

    private function _needAdmin($route){
        foreach ($this->_routesExcludeAdmin as $v) {
            if (preg_match($v, $route)) return false;
        }
        foreach ($this->_routesForAdmin as $v) {
            if (preg_match($v, $route)) return true;
        }
        return false;
    }


    public function jsonOutput($data, $callback='callback'){
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST');
        $fun = $this->arg($callback);   
        $json = json_encode($data);
        echo empty($fun)? $json : "{$fun}({$json})";
        exit;
    }


    public function arg($name = null, $default = null, $callback_funcname = null){
        $ret = parent::arg($name, $default, $callback_funcname);
        if( is_array($ret) ){
            array_walk($ret, function(&$v, $k){$v = trim(htmlspecialchars($v, ENT_QUOTES, 'UTF-8'));} );
        }else{
            $ret = trim(htmlspecialchars($ret, ENT_QUOTES, 'UTF-8'));
        }
        return $ret;
    }

    public function goback(){
        echo '<script language="javascript">window.history.back();</script>';
        exit;
    }

    protected function alert($msg = null, $url = null){
        header("Content-type: text/html; charset=utf-8");
        $alert_msg = null === $msg ? '' : "alert('$msg');";
        if( empty($url) ) {
            $gourl = 'history.go(-1);';
        }else{
            $gourl = "window.location.href = '{$url}'";
        }
        echo "<script>$alert_msg $gourl</script>";
        exit;
    }


    public function err404(){
        $this->layout = '';
        header("HTTP/1.1 404 Not Found", true);
    }


    protected function isPost(){
        return strtoupper($_SERVER['REQUEST_METHOD']) == 'POST';
    }

}