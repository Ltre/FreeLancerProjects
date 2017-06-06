<?php

class ManageController extends BaseController {
    
    public function actionIndex(){
        $p = arg('p', 1);
        $limit = arg('limit', 10);
        $start = arg('start');
        $end = arg('end');
        $keyword = arg('keyword');
        $where = ['AND'];
        if ($start) $where[] = ['vtime', '>=', strtotime($start)];
        if ($end) $where[] = ['vtime', '<=', strtotime($end)];
        if ($keyword) {
            $keywordConds = [
                'OR',
                ['ip', 'like', "%{$keyword}%"],
                ['url', 'like', "%{$keyword}%"],
                ['cookie', 'like', "%{$keyword}%"],
            ];
            if (intval($keyword)) {
                $keywordConds[] = ['uid', '=', intval($keyword)];
                $keywordConds[] = ['id', '=', intval($keyword)];
            }
            $where[] = $keywordConds;
        }
        $queryRs = obj('SeniorModel')->seniorSelect(array(
            'from' => 'tourist',
            'where' => $where,
            'orderBy' => 'id DESC',
            'limitBy' => [$p, $limit, 10],
        ));
        $this->start = $start;
        $this->end = $end;
        $this->keyword = $keyword;
        $this->list = $queryRs['list'];
        $this->pages = $queryRs['pages'];
    }


    public function actionRootist(){
        $p = arg('p', 1);
        $limit = arg('limit', 10);
        $start = arg('start');
        $end = arg('end');
        $keyword = arg('keyword');
        $where = ['AND'];
        if ($start) $where[] = ['vtime', '>=', strtotime($start)];
        if ($end) $where[] = ['vtime', '<=', strtotime($end)];
        if ($keyword) {
            $keywordConds = [
                'OR',
                ['r.ip', 'like', "%{$keyword}%"],
                ['r.url', 'like', "%{$keyword}%"],
            ];
            if (intval($keyword)) {
                $keywordConds[] = ['r.admin_id', '=', intval($keyword)];
                $keywordConds[] = ['r.id', '=', intval($keyword)];
            }
            $where[] = $keywordConds;
        }
        $queryRs = obj('SeniorModel')->seniorSelect(array(
            'select' => 'r.*, a.passport, a.username',
            'from' => 'rootist r JOIN `admin` a ON r.admin_id = a.admin_id',
            'where' => $where,
            'orderBy' => 'id DESC',
            'limitBy' => [$p, $limit, 10],
        ));
        $this->start = $start;
        $this->end = $end;
        $this->keyword = $keyword;
        $this->list = $queryRs['list'];
        $this->pages = $queryRs['pages'];
    }


    public function actionPassword(){
        if ($this->isPost()) {
            $raw = arg('raw');
            $new = arg('new');
            $admin = obj('Admin')->find(array('admin_id' => $this->adminId));
            if (empty($admin)) {
                $this->alert('管理员不存在');
            }
            $saltPassword = obj('Admin')->getSaltPassword($raw);
            if ($saltPassword != $admin['password']) {
                $this->alert('原密码错误');
            }
            $newSaltPassword = obj('Admin')->getSaltPassword($new);
            $rs = obj('Admin')->update(array('admin_id' => $this->adminId), array('password' => $newSaltPassword));
            $success = $rs !== false;
            $this->alert($success ? '修改成功' : '修改失败');
        }
    }


    public function actionLogin(){
        if ($this->isPost()) {
            $passport = arg('passport');
            $password = arg('password');
            if (empty($passport) || empty($password)) {
                $this->alert('通行证或口令为空');
            }
            $admin = obj('Admin')->find(array('passport' => $passport)) ?: array();
            if (empty($admin)) {
                $this->alert('通行证不存在');
            }
            $saltPassword = obj('Admin')->getSaltPassword($password);
            if ($saltPassword != $admin['password']) {
                $this->alert('通行证或口令错误');
            }
            obj('Admin')->setLoginInfoCache($admin['admin_id']);
            header("Location: " . url('manage/index'));
            exit;
        }
        $this->layout = '';
    }


    public function actionLogout(){
        obj('Admin')->delLoginInfoCache();
        header("Location: " . url('manage/login'));
    }


    public function actionAddAdmin(){
        $passport = arg('passport');
        $password = arg('password');
        if (empty($passport) || empty($password)) {
            die('0');
        }
        if (obj('Admin')->find(array('passport' => $passport))) {
            die('-1');
        }
        $password = obj('Admin')->getSaltPassword($password);
        obj('Admin')->insert(compact('passport', 'password'));
        exit('1');
    }


    //记录审计日志
    function actionReportAdmin(){
        obj('Rootist')->append($this->adminId);
    }


    function actionReportNum(){
        $cookieQueryRs = obj('Tourist')->query('SELECT COUNT(1) `cnt` FROM ( SELECT 1 FROM tourist GROUP BY `cookie`) AS tmp') ?: array();
        $data = array(
            'touristNum' => (int) obj("Tourist")->count() ?: 0,
            'rootistNum' => (int) obj("Rootist")->count() ?: 0,
            'cookieNum' => (int) $cookieQueryRs[0]['cnt'] ?: 0,
        );
        $this->jsonOutput(array('rs' => true, 'code' => 0, 'data' => $data));
    }

}
