<?php
require_once("inc_base.php");
require_once($CMS_COMMON_INCLUDE_DIR . "libs.php");
require_once($CMS_COMMON_INCLUDE_DIR . "login_check.php");

// session_start();  //セッションを利用
$account_obj = new caccount();  //アカウントのオブジェクト作成
$weblog_obj = new cweblog();  //ブログのオブジェクト作成
$class_obj = new cclass();  //クラスのオブジェクト作成
$weblog_data = $weblog_obj->get_weblog_content($_GET["id"]);  //ブログIDから記事のデータを取得
$filepath_list = $weblog_obj->get_weblog_filepath_list($_GET["id"]);  //ブログIDから記事に紐づく画像のパスのリストを取得
$_SESSION['TeamA']['delete_weblog_id'] =  $_GET["id"]; //削除時に記事を識別するためにブログIDをセッションに追加

//権限チェック
$account_flag_arr = $account_obj->get_flg($_SESSION['TeamA']['account_id']);  //ログイン中のアカウントの権限を取得
$flag = 2;  //管理者権限を代入
//権限チェック処理
if($account_flag_arr[0]["user_flag"] != $flag){ //アカウントの権限とページの権限が一致しない場合
  $_SESSION['TeamA']['error_message'] = "weblog_detail-アクセスする権限がありません";   //アクセス権限が無い場合セッションにエラーメッセージを追加
  header("location: ../../error.php"); //エラーページへリダイレクト
  exit();
}
//対象記事チェック
$account_classid = $class_obj->get_class_accoid($_SESSION['TeamA']['account_id']); //ログイン中のアカウントのクラスIDを取得
//対象記事チェック処理
if($account_classid["class_id"] != $weblog_data["class_id"]){ //アカウントのクラスIDとページのクラスIDが一致しない場合
  $_SESSION['TeamA']['error_message'] = "weblog_detail-対象外の記事が指定されました";   //アクセス権限が無い場合セッションにエラーメッセージを追加
  header("location: ../../error.php"); //エラーページへリダイレクト
  exit();
}

//記事アップデート処理
if (!empty($_POST["title"])) { //タイトルが入力されている場合
  $weblog_obj->update_weblog($_SESSION['TeamA']['account_id'], $_GET["id"], $_POST["title"], $_POST["textarea1"], $_FILES["input_file"]);  //記事を追加
  unset($_SESSION['TeamA']['delete_weblog_id']);  //削除に利用しないため削除
  header("location: weblog.php"); //アカウント管理トップページへリダイレクト
  exit();
}

//入力フォーム生成表示処理
function make_form(){
  global $weblog_data;
  echo '<div class="mb-3"> <label class="form-label">タイトル</label> <input type="text" class="form-control" name="title" placeholder="title" required="" autofocus="" value="'.$weblog_data["title"] .'"/>' //タイトル入力フォーム
        .'</div> <div class="form-group"> <label for="textarea1">本文</label> <textarea id="textarea1" name="textarea1" class="form-control">' .$weblog_data["contents_weblog"] .'</textarea> </div>' //本文入力フォーム
        .'<label for="inputFile">添付ファイル</label> <div class="custom-file"> <input type="file" multiple accept="image/*" class="custom-file-input" id="input_file" name="input_file[]"> <label class="custom-file-label" for="inputFile">画像ファイルを削除する場合は添付せずに実行してください 2Mbyte未満の画像ファイルに対応</label> </div>'; //画像アップロードフォーム
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
      修正・削除
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
    table.table td a{
      display: block;
    }
  </style>

  <!-- 削除ボタン押下時 -->
  <script language="javascript" type="text/javascript">
    //削除確認アラート表示
    function DeleteCheck() {
      if (confirm("削除を実行します")) { //アラートを表示し、OKがクリックされた場合
        window.location.href = "weblog_delete.php"; //アカウント削除処理ページへリダイレクト
      }
    }
  </script>

</head>

<body class="">
  <div class="wrapper ">
    <div class="sidebar" data-color="orange">
      <!--
        Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red | yellow"
    -->
      <div class="logo">
        <a href="../handouts/handouts.html" class="simple-text logo-normal">
          <center><img src="../../assets/img/SchooLink-2.png"alt="SchooLink"width="120" height="100"></center>
        </a>
      </div>
      <div class="sidebar-wrapper" id="sidebar-wrapper">
        <ul class="nav">
          <li>
            <a href="../handouts/handouts.html">
              <i class="now-ui-icons design_app"></i>
              <p>配布物</p>
            </a>
          </li>
          <li>
            <a href="../tables/tables.html">
              <i class="now-ui-icons education_atom"></i>
              <p>学校スケジュール</p>
            </a>
          </li>
          <li>
            <a href="../suggestion/suggestion.html">
              <i class="now-ui-icons education_atom"></i>
              <p>目安箱</p>
            </a>
          </li>
          <li class="active ">
            <a href="../weblog/weblog.php">
              <i class="now-ui-icons education_atom"></i>
              <p>ブログ・ギャラリー</p>
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
                <h4 class="card-title">修正・削除</h4>
                <form action="" method="post" name="weblog_fix_form" class="weblog_fix_form" enctype="multipart/form-data">
                <?php
                    make_form();  //入力フォーム生成表示
                ?>
                  <input type="button" class="btn btn-danger" value="削除" onclick="DeleteCheck();">
                  <input type="submit" class="btn btn-primary" value="実行">
                </div>
                </form>
              </div>
              <div class="card-body">
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
            &copy; <script>
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
  <script src="../assets/js/now-ui-dashboard.min.js?v=1.5.0" type="text/javascript"></script><!-- Now Ui Dashboard DEMO methods, don't include it in your project! -->
  <script src="../assets/demo/demo.js"></script>
  <script>
    $(document).ready(function() {
      // Javascript method's body can be found in assets/js/demos.js
      demo.initDashboardPageCharts();

    });
  </script>

  <!-- アップロード画像情報の表示処理 -->
  <script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.js"></script>
  <script>
    bsCustomFileInput.init();
  </script>

</body>

</html>