<?php

class AdminController{
    function index(){
        $parent = "Dashboard";
        $position = "Home";

        return include "../view/dashboard/index.php";
    }
}