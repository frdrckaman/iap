<?php
error_reporting(E_ALL ^ E_DEPRECATED);
error_reporting(E_ERROR | E_PARSE);
require_once 'php/core/init.php';
$user = new User();
$override = new OverideData();
$email = new Email();
$random = new Random();
$validate = new validate();
$successMessage = null;
$pageError = null;
$errorMessage = null;

if($user->isLoggedIn()){
	if($_GET['file']){
		$user->download($_GET['file']);
	}else{
		Redirect::to('Dashboard.php');
	}
}else{
	Redirect::to('index.php');
}