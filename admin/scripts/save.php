<?php
  require('../inc/mysql.class.php');
  if ($_REQUEST['action']=='save_image'){
    $path = $_GET['path'];
    $table = $_GET['table'];
    $id = $_GET['id'];
    $value = stripslashes($_GET['value']);
    $query = "update images set title='$value' where id='$id'";
    if ($DB->query($query)){
      echo $value;
    }
  }
  if ($_REQUEST['action']=='save_info'){
    $id = $_GET['id'];
    $page = $_GET['page']; 
    $area = $_GET['area']; 
    $value = stripslashes($_GET['value']); 
    $query = "update $page set $area='$value' where id='$id'";
    if ($DB->query($query)){
      echo $value;
    }
  }
?>