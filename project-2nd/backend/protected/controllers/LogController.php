<?php

class LogController extends BaseController {

    function actionReport(){
        obj('Tourist')->append();
    }

}