<?php
require_once("inc_base.php");
require_once($CMS_COMMON_INCLUDE_DIR . "libs.php");
require_once($CMS_COMMON_INCLUDE_DIR . "login_check.php");

// session_start();  //セッションを利用
$weblog_obj = new cweblog();  //クラスのオブジェクト作成

$weblog_obj->delete_weblog($_SESSION['TeamA']['delete_weblog_id']);	//取得した削除対象のクラスIDを指定して削除
unset($_SESSION['TeamA']['delete_weblog_id']);	//削除が完了したクラスIDをセッションから削除

header("location: weblog.php");	//削除後ブログ管理ページへリダイレクト
exit();
?>