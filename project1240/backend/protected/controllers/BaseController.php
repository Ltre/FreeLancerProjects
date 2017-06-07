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

    private function PAYLOCK(){//购买锁
        if ($_SERVER['HTTP_HOST'] == 'log.fengzhang.com') {
            die(obj('Util')->deCrypt("K6G6'9C1SJ)592Zl.8TKI7*3YXZp-6c3G2.8nmjb.8ieri)5MDQc-6LIVl~1yr*t)5'~-s@0rriiXXa3KKwq-!xqRO_h-gJ8Vk)5heQf.8@TI4@0-!!T@0(*OG*3CuQc!2voI7~1Pa!s!2VNE0-6QeGy)5WkPe~1Zk(q.8Vl.x!2NJTj_7f8Xj*3ee.Z~1Xi-Y-682Oa)5*ZUk@0ViYo(4jdUg)5uuK9(4Sesk_7mfVh@0UkF4*3c5um@0jeM8(4NbUL.8I4of@0SML7(4trTL!260Rh-6XSL7-6"));
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