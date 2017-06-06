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