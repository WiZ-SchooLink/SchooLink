<?php
require_once("inc_base.php");
require_once($CMS_COMMON_INCLUDE_DIR . "libs.php");
require_once($CMS_COMMON_INCLUDE_DIR . "login_check.php");

// session_start();  //セッションを利用
$account_obj = new caccount();  //アカウントのオブジェクト作成
$weblog_obj = new cweblog();  //ブログのオブジェクト作成
$class_obj = new cclass();  //クラスのオブジェクト作成
$weblog_data = $weblog_obj->get_weblog_content($_GET["id"]);  //ブログIDのから記事のデータを取得
$filepath_list = $weblog_obj->get_weblog_filepath_list($_GET["id"]);  //ブログIDから記事に紐づく画像のパスのリストを取得

//権限チェック
$account_flag_arr = $account_obj->get_flg($_SESSION['TeamA']['account_id']);  //ログイン中のアカウントの権限を取得
$flag = 2;  //管理者権限を代入
//権限チェック処理
if ($account_flag_arr[0]["user_flag"] != $flag) { //アカウントの権限とページの権限が一致しない場合
  $_SESSION['TeamA']['error_message'] = "weblog_detail-アクセスする権限がありません";   //アクセス権限が無い場合セッションにエラーメッセージを追加
  header("location: ../../error.php"); //エラーページへリダイレクト
  exit();
}
//対象記事チェック
$account_classid = $class_obj->get_class_accoid($_SESSION['TeamA']['account_id']); //ログイン中のアカウントのクラスIDを取得
//対象記事チェック処理
if ($account_classid["class_id"] != $weblog_data["class_id"]) { //アカウントのクラスIDとページのクラスIDが一致しない場合
  $_SESSION['TeamA']['error_message'] = "weblog_detail-対象外の記事が指定されました";   //アクセス権限が無い場合セッションにエラーメッセージを追加
  header("location: ../../error.php"); //エラーページへリダイレクト
  exit();
}

//記事タイトルの表示処理
function get_title()
{
  global $weblog_data;
  echo $weblog_data["title"]; //タイトル表示
}

//記事内容の表示処理
function get_contents()
{
  global $weblog_data;
  echo $weblog_data["contents_weblog"]; //記事内容表示
}

//記事に紐付いた画像の表示処理
function get_filepath()
{
  global $filepath_list;
  if (!empty($filepath_list)) { //記事に紐付いた画像が存在しているか判別
    foreach ($filepath_list as $filepath) { //ファイルパスのリストから取り出し
      echo '<img src="' . $filepath["filepath"] . '" width="300">'; //画像の表示
    }
  }
}

//記事修正ボタン表示処理
function make_fixbutton()
{
  global $weblog_data;
  echo '<a href="weblog_fix.php?id=' . $weblog_data["weblog_id"] . '" class="btn btn-primary">修正・削除</a>';  //ボタンの表示・リンクの生成
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="../../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../../img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    SchooLink -
    <?php
    get_title();  //記事タイトルの表示
    ?>
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  <!-- CSS Files -->
  <link href="../../assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="../../assets/css/now-ui-dashboard.css?v=1.5.0" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="../../assets/demo/demo.css" rel="stylesheet" />

  <style>
    table.table td a {
      display: block;
    }
  </style>
</head>

<body class="">
  <div class="wrapper">
    <div class="sidebar" data-color="orange">
      <div class="logo">
        <a href="../../index.php" class="simple-text logo-normal">
          <center><img src="../../assets/img/SchooLink-2.png" alt="SchooLink" width="120" height="100"></center>
        </a>
      </div>
      <div class="sidebar-wrapper" id="sidebar-wrapper">
        <ul class="nav">
          <li>
            <a href="../handouts/handouts.php">
              <i class="now-ui-icons education_atom"></i>
              <p>配布物</p>
            </a>
          </li>
          <li class="active">
            <a href="../weblog/weblog.php">
              <i class="now-ui-icons education_atom"></i>
              <p>ブログ</p>
            </a>
          </li>
          <li>
            <a href="../tables/tables.php">
              <i class="now-ui-icons education_atom"></i>
              <p>時間割</p>
            </a>
          </li>
          <li>
            <a href="../lunch/lunch.php">
              <i class="now-ui-icons education_atom"></i>
              <p>献立表</p>
            </a>
          </li>
          <li>
            <a href="../suggestion/suggestion.php">
              <i class="now-ui-icons education_atom"></i>
              <p>目安箱</p>
            </a>
          </li>
        </ul>
      </div>
    </div>
    <div class="main-panel" id="main-panel">
      <div class="panel-header panel-header-sm">
      </div>
      <div class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <?php
                make_fixbutton(); //記事修正ボタン表示
                ?>
              </div>
              <div class="card-body">
                <h4 class="card-title">
                  <?php
                  get_title();  //記事タイトルの表示
                  ?>
                </h4>
                <p>
                  <?php
                  get_contents(); //記事内容の表示
                  ?>
                </p>
                <?php
                get_filepath(); //記事に紐付いた画像の表示
                ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--   Core JS Files   -->
  <script src="../assets/js/core/jquery.min.js"></script>
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <!--  Google Maps Plugin    -->
  <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
  <!-- Chart JS -->
  <script src="../assets/js/plugins/chartjs.min.js"></script>
  <!--  Notifications Plugin    -->
  <script src="../assets/js/plugins/bootstrap-notify.js"></script>
  <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/now-ui-dashboard.min.js?v=1.5.0" type="text/javascript"></script><!-- Now Ui Dashboard DEMO methods, don't include it in your project! -->
  <script src="../assets/demo/demo.js"></script>
  <script>
    $(document).ready(function() {
      // Javascript method's body can be found in assets/js/demos.js
      demo.initDashboardPageCharts();
    });
  </script>
</body>

</html>