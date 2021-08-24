<?php
require_once("inc_base.php");
require_once($CMS_COMMON_INCLUDE_DIR . "libs.php");
require_once($CMS_COMMON_INCLUDE_DIR . "login_check.php");

// session_start();  //セッションを利用
$suggestion_obj = new csuggestion();  //配布物のオブジェクト作成

$suggestion_obj->delete_suggestion($_SESSION['TeamA']['delete_suggestion_id']);	//取得した削除対象の配布物IDを指定して削除
unset($_SESSION['TeamA']['delete_suggestion_id']);	//削除が完了した配布物IDをセッションから削除

header("location: suggestion.php");	//削除後配布物管理ページへリダイレクト
exit();
?>