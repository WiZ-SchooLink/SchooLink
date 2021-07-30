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
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="../../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../../assets/img/SchooLink-2.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
   配布物
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  <!-- CSS Files -->
  <link href="../../assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="../../assets/css/now-ui-dashboard.css" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="../../assets/demo/demo.css" rel="stylesheet" />

  <style>
    table.table td a{
      display: block;
    }
    #cd-nav ul {
      /* mobile first */
      position: fixed;
      width: 90%;
      max-width: 400px;
      max-height: 90%;
      right: 5%;
      bottom: 5%;
      border-radius: 0.25em;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      background: white;
      visibility: hidden;
      /* remove overflow:hidden if you want to create a drop-down menu - but then remember to fix/eliminate the list items animation */
      overflow: hidden;
      overflow-y: auto;
      z-index: 1;
      /* Force Hardware Acceleration in WebKit */
      -webkit-backface-visibility: hidden;
      backface-visibility: hidden;
      -webkit-transform: scale(0);
      -moz-transform: scale(0);
      -ms-transform: scale(0);
      -o-transform: scale(0);
      transform: scale(0);
      -webkit-transform-origin: 100% 100%;
      -moz-transform-origin: 100% 100%;
      -ms-transform-origin: 100% 100%;
      -o-transform-origin: 100% 100%;
      transform-origin: 100% 100%;
      -webkit-transition: -webkit-transform 0.3s, visibility 0s 0.3s;
      -moz-transition: -moz-transform 0.3s, visibility 0s 0.3s;
      transition: transform 0.3s, visibility 0s 0.3s;
    }

    #cd-nav ul li {
      /* Force Hardware Acceleration in WebKit */
      -webkit-backface-visibility: hidden;
      backface-visibility: hidden;
      display: block;
      width: 100%;
      padding: 0;
      text-align: left;
    }

    #cd-nav ul li:hover {
      background-color: #FFF;
    }

    #cd-nav ul.is-visible {
      visibility: visible;
      -webkit-transform: scale(1);
      -moz-transform: scale(1);
      -ms-transform: scale(1);
      -o-transform: scale(1);
      transform: scale(1);
      -webkit-transition: -webkit-transform 0.3s, visibility 0s 0s;
      -moz-transition: -moz-transform 0.3s, visibility 0s 0s;
      transition: transform 0.3s, visibility 0s 0s;
    }

    #cd-nav li a {
      display: block;
      padding: 1em;
      font-size: 1.2rem;
      border-bottom: 1px solid #eff2f6;
    }

    #cd-nav li a:hover {
      color: #333333;
    }

    #cd-nav li:last-child a {
      border-bottom: none;
    }

    .cd-nav-trigger {
      position: fixed;
      bottom: 5%;
      right: 5%;
      width: 44px;
      height: 44px;
      background: white;
      border-radius: 0.25em;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      /* image replacement */
      overflow: hidden;
      text-indent: 100%;
      white-space: nowrap;
      z-index: 2;
    }

    .cd-nav-trigger span {
      /* the span element is used to create the menu icon */
      position: absolute;
      display: block;
      width: 20px;
      height: 2px;
      background: #333333;
      top: 50%;
      margin-top: -1px;
      left: 50%;
      margin-left: -10px;
      -webkit-transition: background 0.3s;
      -moz-transition: background 0.3s;
      transition: background 0.3s;
    }

    .cd-nav-trigger span::before,
    .cd-nav-trigger span::after {
      content: '';
      position: absolute;
      left: 0;
      background: inherit;
      width: 100%;
      height: 100%;
      /* Force Hardware Acceleration in WebKit */
      -webkit-transform: translateZ(0);
      -moz-transform: translateZ(0);
      -ms-transform: translateZ(0);
      -o-transform: translateZ(0);
      transform: translateZ(0);
      -webkit-backface-visibility: hidden;
      backface-visibility: hidden;
      -webkit-transition: -webkit-transform 0.3s, background 0s;
      -moz-transition: -moz-transform 0.3s, background 0s;
      transition: transform 0.3s, background 0s;
    }

    .cd-nav-trigger span::before {
      top: -6px;
      -webkit-transform: rotate(0);
      -moz-transform: rotate(0);
      -ms-transform: rotate(0);
      -o-transform: rotate(0);
      transform: rotate(0);
    }

    .cd-nav-trigger span::after {
      bottom: -6px;
      -webkit-transform: rotate(0);
      -moz-transform: rotate(0);
      -ms-transform: rotate(0);
      -o-transform: rotate(0);
      transform: rotate(0);
    }

    .cd-nav-trigger.menu-is-open {
      box-shadow: none;
    }

    .cd-nav-trigger.menu-is-open span {
      background: rgba(232, 74, 100, 0);
    }

    .cd-nav-trigger.menu-is-open span::before,
    .cd-nav-trigger.menu-is-open span::after {
      background: #333333;
    }

    .cd-nav-trigger.menu-is-open span::before {
      top: 0;
      -webkit-transform: rotate(135deg);
      -moz-transform: rotate(135deg);
      -ms-transform: rotate(135deg);
      -o-transform: rotate(135deg);
      transform: rotate(135deg);
    }

    .cd-nav-trigger.menu-is-open span::after {
      bottom: 0;
      -webkit-transform: rotate(225deg);
      -moz-transform: rotate(225deg);
      -ms-transform: rotate(225deg);
      -o-transform: rotate(225deg);
      transform: rotate(225deg);
    }
  </style>
</head>

   <div class="sidebar" data-color="orange"id="cd-nav">
    <!--
      Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red | yellow"
  -->
    <div class="logo" >
      <a id="cd-nav-trigger" href="#0" class="cd-nav-trigger">Menu<span></span></a>

      <a href="./handouts.html" class="simple-text logo-normal">
        <center><img src="../img/SchooLink-2.png"alt="SchooLink"width="120" height="100"></center>
      </a>
    </div>
    <div class="sidebar-wrapper" id="sidebar-wrapper">
      <ul class="nav" id="cd-main-nav">
        <li class="active ">
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
        <li>
          <a href="../weblog/weblog.html">
            <i class="now-ui-icons education_atom"></i>
            <p>ブログ・ギャラリー</p>
          </a>
        </li>
        <li>
        <a href="../../login/index.html">
          <i class="now-ui-icons education_atom"></i>
          <p>ログアウト</p>
       </li>
        
      </ul>
    </div>
  </div>

  <div class="main-panel" id="main-panel">