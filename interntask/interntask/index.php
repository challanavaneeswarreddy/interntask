<?php
	session_unset();
	require_once  'controller/taskController.php';		
    $controller = new taskController();	
    $controller->mvcHandler();
?>