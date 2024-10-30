<?php
class SystemController extends Controller {
    function index() {
        $this->show('View/system/index');
    }
    function contact() {
        $this->show('View/system/contact');
    }
}