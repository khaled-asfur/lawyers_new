<?php
session_start();
	if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
		$uri = 'https://';
	} else {
		$uri = 'http://';
		$_SESSION['users_page']=1;
	}
	
	if($_SESSION['users_page']!=1){
	$uri .= $_SERVER['HTTP_HOST'];
	header('Location: '.$uri.'/lawyers/html/login.php');
	exit;
	}
	else{
	$uri .= $_SERVER['HTTP_HOST'];
	header('Location: '.$uri.'/lawyers/html/Lowyer.html');
	exit;
    }
?>
