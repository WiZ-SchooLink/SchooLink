<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>SchooLink</title>

	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
	<style type="text/css">
		body {
			padding-top: 80px;
		}

		@media (min-width: 768px) {
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
	<?php
	require_once('assets/Smarty/smarty-3.1.39/libs/Smarty.class.php');
	$smarty = new Smarty();
	$smarty->template_dir = 'assets/Smarty/template';
	$smarty->compile_dir = 'assets/Smarty/template_c';

	$smarty->display('header.tpl')
	?>

	<div class="container">
		<div class="page-header" id="banner">
			<div class="row">
				<div class="col-lg-8 col-md-7 col-sm-6">
					<h1>SchooLink​</h1>
					<p class="lead">SchooLink​は学校と親をつなぐサービスです</p>
					<a href="login/index.php" class="btn btn-primary">ログイン</a>
				</div>
			</div>
		</div>

		<div class="page-header" id="banner">
			<h1>SchooLink​は学校と親をつなぐサービスです</h1>
			<p class="lead">SchooLink​は以下の機能が含まれています</p>

			<div class="col-md-3 col-sm-6 point-box">
				<div class="point-circle start">
					<i class="fa fa-check"></i>
				</div>
				<div class="point-description">
					<h4>配布物・ブログ機能</h4>
					<p>配布物・ブログの確認機能があります</p>
				</div>
			</div>

			<div class="col-md-3 col-sm-6 point-box">
				<div class="point-circle start">
					<i class="fa fa-check"></i>
				</div>
				<div class="point-description">
					<h4>給食献立・時間割・目安箱機能</h4>
					<p>給食献立・時間割・目安箱機能があります</p>
				</div>
			</div>
		</div>

		<div class="page-header" id="banner">
			<h1>SchooLink​はセキュリティを強化しています</h1>
			<p class="lead">個人情報を扱うSchooLinkではセキュリティを強化しています</p>

			<div class="col-md-3 col-sm-6 point-box">
				<div class="point-circle start">
					<i class="fa fa-check"></i>
				</div>
				<div class="point-description">
					<h4>アクセス制御</h4>
					<p>適切なアクセス制御を実施しています</p>
				</div>
			</div>

			<div class="col-md-3 col-sm-6 point-box">
				<div class="point-circle start">
					<i class="fa fa-check"></i>
				</div>
				<div class="point-description">
					<h4>アカウント管理</h4>
					<p>適切なアカウント管理を実施しています</p>
				</div>
			</div>
		</div>
	</div>

	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>

	<script type="text/javascript">
		$('.bs-component [data-toggle="popover"]').popover();
		$('.bs-component [data-toggle="tooltip"]').tooltip();
	</script>

</body>

</html>