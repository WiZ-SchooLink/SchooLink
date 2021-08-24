<?php
require_once("inc_base.php");
require_once($CMS_COMMON_INCLUDE_DIR . "libs.php");
require_once($CMS_COMMON_INCLUDE_DIR . "login_check.php");

// session_start();  //セッションを利用
$like_obj = new clikes();  //いいねのオブジェクト作成
$suggestion_id = $_SESSION['TeamA']['like_suggestion_id'];

$like_obj->insert_likes($_SESSION['TeamA']['account_id'], $_SESSION['TeamA']['like_suggestion_id']);	//取得したいいね対象の目安箱IDとアカウントIDを指定していいね
unset($_SESSION['TeamA']['like_suggestion_id']);	//削除が完了した目安箱IDをセッションから削除

header("location: suggestion_detail.php?id=" .$suggestion_id);	//いいね後いいねした記事へリダイレクト
exit();
?>