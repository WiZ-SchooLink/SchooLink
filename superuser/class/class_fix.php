<?php
require_once("inc_base.php");
require_once($CMS_COMMON_INCLUDE_DIR . "libs.php");
require_once($CMS_COMMON_INCLUDE_DIR . "login_check.php");

// session_start();  //セッションを利用
$account_obj = new caccount();  //アカウントのオブジェクト作成
$class_obj = new cclass();  //クラスのオブジェクト作成
$select_class_data = $class_obj->get_class_info($_GET["id"]); //クラス情報修正対象のクラスIDからそのクラスの情報を取得
$schoolname_array = $account_obj->get_school_classinfo($_SESSION['TeamA']['account_id']);  //ログイン中のアカウントの学校の全クラスの情報の配列を取得
$_SESSION['TeamA']['delete_class_id'] =  $select_class_data["class_id"]; //削除時にクラスを識別するためにクラスIDをセッションに追加

//権限チェック
$account_flag_arr = $account_obj->get_flg($_SESSION['TeamA']['account_id']);  //ログイン中のアカウントの権限を取得
$flag = 3;  //最上位管理者権限を代入
//権限チェック処理
if ($account_flag_arr[0]["user_flag"] != $flag) { //アカウントの権限とページの権限が一致しない場合
  $_SESSION['TeamA']['error_message'] = "class_fix-アクセスする権限がありません";   //アクセス権限が無い場合セッションにエラーメッセージを追加
  header("location: ../../error.php"); //エラーページへリダイレクト
  exit();
}

foreach ($schoolname_array as $class_array) { //管理対象のクラスID
  if ($select_class_data["class_id"] == $class_array["class_id"]) { //修正するクラスIDと管理対象クラスIDが一致した場合
    break;  //クラスIDチェックからbreak
  }
  if ($class_array === end($schoolname_array)) {  //一致しないまま最後まで比較された場合
    $_SESSION['TeamA']['error_message'] = "class_fix-管理外のクラスが指定されました";   //管理外のアカウントが指定されていた場合セッションにエラーメッセージを追加
    header("location: ../../error.php"); //エラーページへリダイレクト
    exit();
  }
}

//クラス情報修正処理
if (!empty($_POST["grade"]) and !empty($_POST["class_name"])) { //すべてが入力されている場合
  global $class_obj, $account_obj;
  $schoolid_array = $account_obj->get_school_id($_SESSION['TeamA']['account_id']);  //自分の学校のIDを取得
  $class_obj->updata_class($select_class_data["class_id"], $schoolid_array["school_id"], $_POST["grade"], $_POST["class_name"]); //クラス情報修正
  unset($_SESSION['TeamA']['delete_class_id']);  //削除に利用しないため削除
  header("location: class.php"); //クラス管理トップページへリダイレクト
  exit();
}

//クラスの情報を入力フォームの中身に代入して表示
function make_form()
{
  global $select_class_data;
  echo '<div class="mb-3"> <label class="form-label">学年</label> <input type="number" class="form-control" name="grade" placeholder="Grade" required="" autofocus="" max="6" value="' . $select_class_data["grade"] . '"/> </div>'
    . '<div class="mb-3"> <label class="form-label">クラス名</label> <input type="text" class="form-control" name="class_name" placeholder="ClassName" required="" value="' . $select_class_data["class_name"] . '"/> </div>';
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
    SchooLink - クラス情報修正
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
      if (confirm("削除を実行します\nそのクラスに紐付いた配布物･アカウントなども削除されます")) { //アラートを表示し、OKがクリックされた場合
        window.location.href = "class_delete.php"; //クラス削除処理ページへリダイレクト
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
          <li>
            <a href="../account/account.php">
              <i class="now-ui-icons design_app"></i>
              <p>アカウント管理</p>
            </a>
          </li>
          <li class="active">
            <a href="../class/class.php">
              <i class="now-ui-icons education_atom"></i>
              <p>クラス管理</p>
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
                <h4 class="card-title"> クラス情報修正</h4>
              </div>
              <div class="card-body">
                <form action="" method="post" name="class_fix_form" class="class_fix_form">
                  <?php
                  //クラスの情報を入力フォームの中身に代入して表示する処理を実行
                  make_form();
                  ?>
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