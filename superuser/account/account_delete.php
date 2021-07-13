<?php
require_once("inc_base.php");
require_once($CMS_COMMON_INCLUDE_DIR . "libs.php");
require_once($CMS_COMMON_INCLUDE_DIR . "login_check.php");

// session_start();  //セッションを利用
$account_obj = new caccount();  //アカウントのオブジェクト作成

$account_obj->delete_account($_SESSION['TeamA']['delete_account_id']);	//取得した削除対象のアカウントIDを指定して削除
unset($_SESSION['TeamA']['delete_account_id']);	//削除が完了したアカウントIDをセッションから削除

header("location: account.php");	//削除後アカウント管理ページへリダイレクト
?>