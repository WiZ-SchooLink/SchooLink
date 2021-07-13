<!--

=========================================================
* Now UI Dashboard - v1.5.0
=========================================================

* Product Page: https://www.creative-tim.com/product/now-ui-dashboard
* Copyright 2019 Creative Tim (http://www.creative-tim.com)

* Designed by www.invisionapp.com Coded by www.creative-tim.com

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

-->
<?php
require_once("inc_base.php");
require_once($CMS_COMMON_INCLUDE_DIR . "libs.php");

session_start();  //セッションを利用
$account_obj = new caccount();  //アカウントのオブジェクト作成
$schoolname_array = $account_obj->get_school_classinfo($_SESSION['TeamA']['account_id']);  //ログイン中のアカウントの学校の全クラスの情報の配列を取得

//アカウント新規追加処理
if (!empty($_POST["login_name"]) and !empty($_POST["login_pass"]) and !empty($_POST["user_name"]) and !empty($_POST["class_id"]) and !empty($_POST["user_flag"])) { //すべてが入力されている場合
  foreach($schoolname_array as $class_array){ //管理対象のクラスID
    if($_POST["class_id"] == $class_array["class_id"]){ //追加するクラスIDと管理対象クラスIDが一致した場合
      $account_obj->insert_account($_POST["login_name"], $_POST["login_pass"], $_POST["class_id"], $_POST["user_name"], $_POST["user_flag"]); //アカウント新規追加
      header("location: account.php"); //アカウント管理トップページへリダイレクト
      exit();
    }
  }
  $_SESSION['TeamA']['error_message'] = "account_add-管理外のクラスIDが指定されました";   //管理外のクラスIDが指定されていた場合セッションにエラーメッセージを追加
  header("location: ../../error.php"); //エラーページへリダイレクト
  exit();
}

//クラス名リスト自動生成
function make_schoollist($row)
{ //1クラス分の配列
  echo '<option value="' . $row["class_id"] . '">' . $row["class_name"] . '</option>';  //valueにクラスIDを代入、内容にクラス名を代入
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
    アカウント新規追加
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
  <div class="wrapper ">
    <div class="sidebar" data-color="orange">
      <!--
        Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red | yellow"
    -->
      <div class="logo">

        <a href="../handouts/handouts.html" class="simple-text logo-normal">
          <center><img src="../../assets/img/SchooLink-2.png" alt="SchooLink" width="120" height="100"></center>
        </a>
      </div>
      <div class="sidebar-wrapper" id="sidebar-wrapper">
        <ul class="nav">
          <li class="active ">
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
                <h4 class="card-title"> アカウント新規追加</h4>
              </div>
              <div class="card-body">
                <form action="" method="post" name="account_add_form" class="account_add_form">
                  <div class="mb-3">
                    <label class="form-label">ログイン名</label>
                    <input type="text" class="form-control" name="login_name" placeholder="LoginName" required="" autofocus="" />
                  </div>
                  <div class="mb-3">
                    <label class="form-label">ログインパスワード</label>
                    <input type="password" class="form-control" name="login_pass" placeholder="LoginPass" required="" />
                  </div>
                  <div class="mb-3">
                    <label class="form-label">ユーザー名</label>
                    <input type="text" class="form-control" name="user_name" placeholder="UserName" required="" />
                  </div>
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
                      <option value="1">ユーザー</option>
                      <option value="2">管理者</option>
                      <option value="3">最上位管理者</option>
                    </select>
                  </div>
                  <input type="submit" class="btn btn-primary" value="実行">
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <footer class="footer">
        <div class=" container-fluid ">
          <nav>
            <ul>
              <li>
                <a href="https://www.creative-tim.com">
                  Creative Tim
                </a>
              </li>
              <li>
                <a href="http://presentation.creative-tim.com">
                  About Us
                </a>
              </li>
              <li>
                <a href="http://blog.creative-tim.com">
                  Blog
                </a>
              </li>
            </ul>
          </nav>
          <div class="copyright" id="copyright">
            &copy;
            <script>
              document.getElementById('copyright').appendChild(document.createTextNode(new Date().getFullYear()))
            </script>, Designed by <a href="https://www.invisionapp.com" target="_blank">Invision</a>. Coded by <a href="https://www.creative-tim.com" target="_blank">Creative Tim</a>.
          </div>
        </div>
      </footer>
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