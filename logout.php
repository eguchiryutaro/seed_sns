<?php

	//セッション変数の中身を上書きして空にする
	$_SESSION = array();

	if (ini_get("session.use_coolies")){
		$params = session_get_cookie_params();
		setcookie(session_name(),'',time() - 42000,$params['path'],$params['domain'],$params['secure'],$params['httponly']);
	}

	session_destroy();

	//cookie情報も削除	
	setcookie('email','',time() - 3600);
	setcookie('password','',time() - 3600);

	header("Location: index.php");
	exit() ;

?>