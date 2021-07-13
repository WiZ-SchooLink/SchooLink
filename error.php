<?php
require_once("inc_base.php");
require_once($CMS_COMMON_INCLUDE_DIR . "libs.php");

session_start();  //セッションを利用

//セッションに保存されているエラーメッセージを表示する処理
function print_error_message(){
	echo $_SESSION['TeamA']['error_message'];	//エラーメッセージ表示
	$_SESSION['TeamA'] = array(); //セッション初期化
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>SchooLink</title>

	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
	<style type="text/css">
	body { padding-top: 80px; }
	@media ( min-width: 768px ) {
		#banner {
			min-height: 300px;
			border-bottom: none;
		}
		.bs-docs-section {
			margin-top: 8em;
		}
		.bs-component {
			position: relative;
		}
		.bs-component .modal {
			position: relative;
			top: auto;
			right: auto;
			left: auto;
			bottom: auto;
			z-index: 1;
			display: block;
		}
		.bs-component .modal-dialog {
			width: 90%;
		}
		.bs-component .popover {
			position: relative;
			display: inline-block;
			width: 220px;
			margin: 20px;
		}
		.nav-tabs {
			margin-bottom: 15px;
		}
		.progress {
			margin-bottom: 10px;
		}
	}
	</style>



</head>
<body>

<header>
	<div class="navbar navbar-default navbar-fixed-top">
		<div class="container">
			<div class="navbar-header">
				<a href="index.html" class="navbar-brand">SchooLink​</a>
				<button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button> 
			</div>
			<div class="navbar-collapse collapse" id="navbar-main">
				<ul class="nav navbar-nav">
					<li><a href="index.html">Top</a></li>
					<li><a href="login/index.php">ログイン</a></li>
				</ul>
			</div>
		</div>
	</div>
</header>

<div class="container">

	<div class="page-header" id="banner">
		<div class="row">
			<div class="col-lg-8 col-md-7 col-sm-6">
				<h1>エラー</h1>
				<p class="lead">
					<?php
					print_error_message();	//セッションに保存されているエラーメッセージを表示する処理実行
					?>
				</p>
				<p>再ログインして再度やり直してください</p>

				<a href="login/index.php" class="btn btn-primary">再ログイン</a>
			</div>
		</div>
	</div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>

<script type="text/javascript">
	$('.bs-component [data-toggle="popover"]').popover();
	$('.bs-component [data-toggle="tooltip"]').tooltip();
</script>

</body>
</html>
