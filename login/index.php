<style>
  .wrapper {
    margin-top: 80px;
    margin-bottom: 20px;
  }

  .form-signin {
    max-width: 420px;
    padding: 30px 38px 66px;
    margin: 0 auto;
    background-color: #eee;
    border: 3px dotted rgba(0, 0, 0, 0.1);
  }

  .form-signin-heading {
    text-align: center;
    margin-bottom: 30px;
  }

  .form-control {
    position: relative;
    font-size: 16px;
    height: auto;
    padding: 10px;
  }

  input[type="text"] {
    margin-bottom: 0px;
    border-bottom-left-radius: 0;
    border-bottom-right-radius: 0;
  }

  input[type="password"] {
    margin-bottom: 20px;
    border-top-left-radius: 0;
    border-top-right-radius: 0;
  }

  .colorgraph {
    height: 7px;
    border-top: 0;
    background: #c4e17f;
    border-radius: 5px;
    background-image: -webkit-linear-gradient(left, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
    background-image: -moz-linear-gradient(left, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
    background-image: -o-linear-gradient(left, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
    background-image: linear-gradient(to right, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
  }
</style>

<?php
require_once("inc_base.php");
require_once($CMS_COMMON_INCLUDE_DIR . "libs.php");

session_start();  //セッションを利用

$_SESSION['TeamA'] = array(); //セッション初期化

//ログイン名とパスワードの入力値を取得してアカウントIDを取得
if (!empty($_POST["LoginName"]) and !empty($_POST["Password"])) { //ログイン名とパスワードが入力されている場合
  $obj = new caccount();  //アカウントのオブジェクト作成
  $arr = $obj->get_tgt(strip_tags($_POST['LoginName']), strip_tags($_POST['Password']));  //アカウントID配列取得
  if (!empty($arr)) { //アカウントIDの配列に中身がある場合(ログインが成功した場合)
    $_SESSION['TeamA']['account_id'] =  $arr[0]["account_id"];  //アカウントID配列からアカウントIDを取り出してセッションに追加
    $arr = $obj->get_flg($_SESSION['TeamA']['account_id']); //セッション内のアカウントIDを利用して権限判別値配列を取得
    switch ($arr[0]["user_flag"]) { //権限判別値配列から権限判別値を取り出して判別
      case "1": //ユーザー権限
        header("location: ../user/handouts/handouts.html"); //ユーザー用の配布物ページへリダイレクト
        exit();
        break;
      case "2": //管理者権限
        header("location: ../administrator/handouts/handouts.html");  //管理者用の配布物ページへリダイレクト
        exit();
        break;
      case "3": //最上位管理者権限
        header("location: ../superuser/account/account.php");  //最上位管理者用のアカウント管理ページへリダイレクト
        exit();
        break;
    }
  } else {  //アカウントIDの配列に中身が無い場合(ログインが失敗した場合)
    echo "ユーザー名かパスワードが違います";
  }
}
?>

<link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<div class="container">
  <div class="wrapper">
    <form action="" method="post" name="Login_Form" class="form-signin">
      <h3 class="form-signin-heading">SchooLinkへようこそ</h3>
      <hr class="colorgraph"><br>

      <input type="text" class="form-control" name="LoginName" placeholder="LoginName" required="" autofocus="" />
      <input type="password" class="form-control" name="Password" placeholder="Password" required="" />

      <input type="submit" class="btn btn-primary" value="ログイン">
      <a href="../referral/index.html" class="btn btn-secondry">導入紹介はこちら</a>
    </form>
  </div>
</div>