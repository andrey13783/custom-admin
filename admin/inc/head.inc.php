<?php
  session_start();
  error_reporting(E_ALL);
  
  include('config.php');
  require('inc/mysql.class.php');
  
  if (isset($_POST['login']) && !empty($_POST['login']) && isset($_POST['pass'])){
    if ($user = $DB->getData("select * from adm_users where title='".$_POST['login']."' && password='".$_POST['pass']."'")){
      $_SESSION['adm_user'] = $_POST['login'];
    }
    else $error_mess = "<div class='error_mess'>Неверный логин или пароль</div>";
    header("Location: index.php");
  }
  if (isset($_REQUEST['logout'])){
    unset($_SESSION['adm_user']);
    header("Location: index.php");
  }

  if (!isset($_SESSION['adm_user'])){
    include("templates/auth.php");
    exit();
  }
  
  date_default_timezone_set('Europe/Moscow');
  $date = date('Y-m-d');
  $months = array('01'=>'Январь','02'=>'Февраль','03'=>'Март','04'=>'Апрель','05'=>'Май','06'=>'Июнь','07'=>'Июль','08'=>'Август','09'=>'Сентябрь','10'=>'Октябрь','11'=>'Ноябрь','12'=>'Декабрь');
  $months2 = array('01'=>'января','02'=>'февраля','03'=>'марта','04'=>'апреля','05'=>'мая','06'=>'июня', '07'=>'июля','08'=>'августа','09'=>'сентября','10'=>'октября','11'=>'ноября','12'=>'декабря');
  
  $adm_user = $DB->getData("select * from adm_users where title='".$_SESSION['adm_user']."'")[0];  

  $main_menu = array();
  $menu = $DB->getData("select * from adm_menu where level='0' && sh='1' && adm_access like '%".$adm_user['access']."%' order by id");
  foreach ($menu as $m){  
    $main_menu[$m['id']]['link'] = !empty($m['link']) ? $m['link'] : '';
    $main_menu[$m['id']]['title'] = $m['title'];
    $main_menu[$m['id']]['icon'] = !empty($m['icon']) ? $m['icon'] : 'fa-bars';
    $main_menu[$m['id']]['id'] = $m['id'];
    $sub_menu = $DB->getData("select * from adm_menu where level='".$m['id']."' && sh='1' && adm_access like '%".$adm_user['access']."%' order by id");
    foreach ($sub_menu as $sm){
      $main_menu[$m['id']]['child'][$sm['id']]['page'] = $sm['page'];
      $main_menu[$m['id']]['child'][$sm['id']]['link'] = !empty($sm['link']) ? $sm['link'] : 'table.php?page='.$sm['page'];
      $main_menu[$m['id']]['child'][$sm['id']]['image'] = !empty($sm['image']) ? '/images/adm_menu/'.$sm['image'] : 'images/files.gif';
      $main_menu[$m['id']]['child'][$sm['id']]['title'] = $sm['title'];
      $main_menu[$m['id']]['child'][$sm['id']]['id'] = $sm['id'];
    }
  }
  
  if (!empty($_REQUEST['amth'])){
    $_SESSION['amth'] = $_REQUEST['amth'];
  }
  //echo "<pre>"; print_r($main_menu); echo "</pre>";
  include("templates/header.php");
?>