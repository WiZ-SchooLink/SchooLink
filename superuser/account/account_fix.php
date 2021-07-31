<?php
require_once("inc_base.php");
require_once($CMS_COMMON_INCLUDE_DIR . "libs.php");
require_once($CMS_COMMON_INCLUDE_DIR . "login_check.php");

// session_start();  //セッションを利用
$account_obj = new caccount();  //アカウントのオブジェクト作成
$schoolname_array = $account_obj->get_school_classinfo($_SESSION['TeamA']['account_id']);  //ログイン中のアカウントの学校の全クラスの情報の配列を取得
$select_user_data = $account_obj->get_accinfo($_GET["id"]); //アカウント情報修正対象のログインIDからそのアカウントの情報を取得
$_SESSION['TeamA']['delete_account_id'] =  $select_user_data["account_id"]; //削除時にアカウントを識別するためにアカウントIDをセッションに追加

//権限チェック
$account_flag_arr = $account_obj->get_flg($_SESSION['TeamA']['account_id']);  //ログイン中のアカウントの権限を取得
$flag = 3;  //最上位管理者権限を代入
//権限チェック処理
if ($account_flag_arr[0]["user_flag"] != $flag) { //アカウントの権限とページの権限が一致しない場合
  $_SESSION['TeamA']['error_message'] = "account_fix-アクセスする権限がありません";   //アクセス権限が無い場合セッションにエラーメッセージを追加
  header("location: ../../error.php"); //エラーページへリダイレクト
  exit();
}

foreach ($schoolname_array as $class_array) { //管理対象のクラスID
  if ($select_user_data["class_id"] == $class_array["class_id"]) { //追加するクラスIDと管理対象クラスIDが一致した場合
    break;  //クラスIDチェックからbreak
  }
  if ($class_array === end($schoolname_array)) {  //一致しないまま最後まで比較された場合
    $_SESSION['TeamA']['error_message'] = "account_fix-管理外のアカウントが指定されました";   //管理外のアカウントが指定されていた場合セッションにエラーメッセージを追加
    header("location: ../../error.php"); //エラーページへリダイレクト
    exit();
  }
}
//アカウント情報修正処理
if (!empty($_POST["login_name"]) and !empty($_POST["class_id"]) and !empty($_POST["user_name"]) and !empty($_POST["user_flag"])) { //すべて入力されている場合(パスワードは空の場合あり)

  foreach ($schoolname_array as $class_array) { //管理対象のクラスID
    if ($_POST["class_id"] == $class_array["class_id"]) { //追加するクラスIDと管理対象クラスIDが一致した場合
      $account_obj->updata_account($select_user_data["account_id"], $_POST["login_name"], $_POST["login_pass"], $_POST["class_id"], $_POST["user_name"], $_POST["user_flag"]); //アカウント情報修正
      unset($_SESSION['TeamA']['delete_account_id']);  //削除に利用しないため削除
      header("location: account.php"); //アカウント管理トップページへリダイレクト
      exit();
    }
  }
  $_SESSION['TeamA']['error_message'] = "account_fix-管理外のクラスIDが指定されました";   //管理外のクラスIDが指定されていた場合セッションにエラーメッセージを追加
  header("location: ../../error.php"); //エラーページへリダイレクト
  exit();
}

//クラス名リスト自動生成
function make_schoollist($row)
{
  global $select_user_data;
  //対象のアカウントのクラスIDと合致する学校名を初期選択
  if ($row["class_id"] == $select_user_data["class_id"]) {  //リストのクラスIDと対象のアカウントのクラスIDが合致した場合
    echo '<option value="' . $row["class_id"] . '"  selected>' . $row["class_name"] . '</option>';  //valueにクラスIDを代入、内容にクラス名を代入、初期選択
  } else {
    echo '<option value="' . $row["class_id"] . '">' . $row["class_name"] . '</option>';  //valueにクラスIDを代入、内容にクラス名を代入
  }
}

//権限リスト自動生成
function make_flaglist()
{
  global $select_user_data;
  //対象のアカウントの権限と合致する権限名を初期選択
  switch ($select_user_data["user_flag"]) {
    case 1: //対象のアカウントの権限がユーザーの場合
      echo '<option value="1" selected>ユーザー</option> <option value="2">管理者</option> <option value="3">最上位管理者</option>';
      break;
    case 2: //対象のアカウントの権限が管理者の場合
      echo '<option value="1">ユーザー</option> <option value="2" selected>管理者</option> <option value="3">最上位管理者</option>';
      break;
    case 3: //対象のアカウントの権限が最上位管理者の場合
      echo '<option value="1">ユーザー</option> <option value="2">管理者</option> <option value="3" selected>最上位管理者</option>';
      break;
  }
}

//アカウントの情報を入力フォームの中身に代入して表示
function make_form()
{
  global $select_user_data;
  echo '<div class="mb-3"> <label class="form-label">ログイン名</label> <input type="text" class="form-control" name="login_name" placeholder="LoginName" required="" autofocus="" value="' . $select_user_data["login_name"] . '"/> </div>'
    . '<div class="mb-3"> <label class="form-label">ログインパスワード</label> <input type="password" class="form-control" name="login_pass" placeholder="LoginPass 修正しない場合は空欄"/> </div>'
    . '<div class="mb-3"> <label class="form-label">ユーザー名</label> <input type="text" class="form-control" name="user_name" placeholder="UserName" required="" value="' . $select_user_data["user_name"] . '"/> </div>';
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="../../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../../assets/img/SchooLink-2.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    SchooLink - アカウント情報修正
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

  <!-- 削除ボタン押下時 -->
  <script language="javascript" type="text/javascript">
    //削除確認アラート表示
    function DeleteCheck() {
      if (confirm("削除を実行します")) { //アラートを表示し、OKがクリックされた場合
        window.location.href = "account_delete.php"; //アカウント削除処理ページへリダイレクト
      }
    }
  </script>

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
          <li class="active">
            <a href="../account/account.php">
              <i class="now-ui-icons design_app"></i>
              <p>アカウント管理</p>
            </a>
          </li>
          <li>
            <a href="../class/class.php">
              <i class="now-ui-icons education_atom"></i>
              <p>クラス管理</p>
            </a>
          </li>
        </ul>
      </div>
    </div>
    <div class="main-panel" id="main-panel">

      <!-- End Navbar -->
      <div class="panel-header panel-header-sm">
      </div>
      <div class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title"> アカウント情報修正</h4>
              </div>
              <div class="card-body">
                <form action="" method="post" name="account_fix_form" class="account_fix_form">
                  <?php
                  //アカウントの情報を入力フォームの中身に代入して表示する処理を実行
                  make_form();
                  ?>
                  <div class="mb-3">
                    <label class="form-label">クラス</label>
                    <select class="form-select" name="class_id">
                      <?php
                      //クラス名リスト自動生成実行
                      foreach ($schoolname_array as $row) {  //取得したリスト数分ループ
                        make_schoollist($row);  //一人分のデータを代入して実行
                      }
                      ?>
                    </select>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">権限</label>
                    <select class="form-select" name="user_flag">
                      <?php
                      //権限リスト自動生成を実行
                      make_flaglist();
                      ?>
                    </select>
                  </div>
                  <input type="button" class="btn btn-danger" value="削除" onclick="DeleteCheck();">
                  <input type="submit" class="btn btn-primary" value="実行">
                </form>
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
  <script src="../assets/js/now-ui-dashboard.min.js?v=1.5.0" type="text/javascript"></script>
  <!-- Now Ui Dashboard DEMO methods, don't include it in your project! -->
  <script src="../assets/demo/demo.js"></script>
  <script>
    $(document).ready(function() {
      // Javascript method's body can be found in assets/js/demos.js
      demo.initDashboardPageCharts();
    });
  </script>
</body>

</html>