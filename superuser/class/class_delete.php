<?php
require_once("inc_base.php");
require_once($CMS_COMMON_INCLUDE_DIR . "libs.php");
require_once($CMS_COMMON_INCLUDE_DIR . "login_check.php");

// session_start();  //セッションを利用
$class_obj = new cclass();  //クラスのオブジェクト作成

$class_obj->delete_class($_SESSION['TeamA']['delete_class_id']);	//取得した削除対象のクラスIDを指定して削除
unset($_SESSION['TeamA']['delete_account_id']);	//削除が完了したクラスIDをセッションから削除

header("location: class.php");	//削除後クラス管理ページへリダイレクト
?>