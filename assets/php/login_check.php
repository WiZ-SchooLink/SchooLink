<?php
session_start();

//セッション内にアカウントIDが無い場合
if(!isset($_SESSION['TeamA']['account_id'])){
	header("location: ../../login/index.php"); //ログインページへリダイレクト
	exit();
}

?>