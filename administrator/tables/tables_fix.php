<?php
require_once("inc_base.php");
require_once($CMS_COMMON_INCLUDE_DIR . "libs.php");
require_once($CMS_COMMON_INCLUDE_DIR . "login_check.php");

// session_start();  //セッションを利用
$account_obj = new caccount();  //アカウントのオブジェクト作成
$class_obj = new cclass();  //クラスのオブジェクト作成

//権限チェック
$account_flag_arr = $account_obj->get_flg($_SESSION['TeamA']['account_id']);  //ログイン中のアカウントの権限を取得
$flag = 2;  //管理者権限を代入
//権限チェック処理
if ($account_flag_arr[0]["user_flag"] != $flag) { //アカウントの権限とページの権限が一致しない場合
  $_SESSION['TeamA']['error_message'] = "table_fix-アクセスする権限がありません";   //アクセス権限が無い場合セッションにエラーメッセージを追加
  header("location: ../../error.php"); //エラーページへリダイレクト
  exit();
}

$err_flag = false;  //エラー表示判別用フラグ
//時間割画像アップロード処理
if (!empty($_FILES)) {  //修正をクリックした場合
  if ($_FILES["input_file"]["size"] > 0) {  //画像が存在する場合
    $account_obj->insert_schedule($_SESSION['TeamA']['account_id'], $_FILES["input_file"]);  //献立表画像をアップロード
    header("location: tables.php"); //献立表トップページへリダイレクト
    exit();
  } else {
    $err_flag = true; //エラー
  }
}

//エラー表示処理
function error_message()
{
  global $err_flag;
  if ($err_flag) {
    echo "画像のアップロード可能ファイルサイズは2Mbyteまでです";
    $err_flag = false;
  }
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
    SchooLink - 時間割修正
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
          <li>
            <a href="../weblog/weblog.php">
              <i class="now-ui-icons education_atom"></i>
              <p>ブログ</p>
            </a>
          </li>
          <li class="active">
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
                <h4 class="card-title">時間割修正</h4>
                <form action="" method="post" name="schedule_fix_form" class="schedule_fix_form" enctype="multipart/form-data">
                  <div class="form-group">
                    <label for="inputFile">時間割画像</label>
                    <div class="custom-file">
                      <input type="file" accept="image/*" class="custom-file-input" id="input_file" name="input_file">
                      <label class="custom-file-label" for="inputFile">画像ファイルをアップロードしてください</label>
                    </div>
                  </div>
                  <input type="submit" class="btn btn-primary" value="実行">
                </form>
                <p>
                  <?php
                  error_message();  //エラー表示
                  ?>
                </p>
              </div>
              <div class="card-body">
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

  <script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.js"></script>
  <script>
    bsCustomFileInput.init();
  </script>
</body>

</html>