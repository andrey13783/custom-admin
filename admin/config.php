<?php
  // Количество записей на странице
  $page_length = 30;
  // Пнерень выводимых в таблице полей
  $view_culumns = array('title','value','date','status','field','sh','mail','sort','price','image');
  // Перечень полей, доступных для быстрого редактирования
  $edit_culumns = array('title','value','date','price');
  
  // Данные для посдключения к БД
  if ($_SERVER['REMOTE_ADDR']=='127.0.0.1'){
    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = '';
    $dbname = 'ehoho';
  }
  else{
    $dbhost = 'localhost';
    $dbuser = 'u26452_mysql';
    $dbpass = 'hR#23_Nk9#jZ1&5j-^Yu45@';
    $dbname = 'u26452_ehoho';
  }
?>