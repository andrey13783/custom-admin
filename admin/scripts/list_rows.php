<?php
  session_start();
  error_reporting(E_ALL);
  require('../inc/mysql.class.php');
  require('../scripts/functions.php');
  require('../config.php');
  date_default_timezone_set('Europe/Moscow');
  $date = date('Y-m-d');
  if (!empty($_REQUEST['page'])){
    $page = $_REQUEST['page'];
    $level = !empty($_REQUEST['level']) ? $_REQUEST['level'] : 0;
    $filter = !empty($_REQUEST['filter']) ? $_REQUEST['filter'] : '';
    $search = !empty($_REQUEST['search']) ? $_REQUEST['search'] : '';
    $pnum = !empty($_REQUEST['pnum']) ? $_REQUEST['pnum'] : 1;
    $amth = !empty($_SESSION['amth']) ? $_SESSION['amth'] : $page_length; // Количество строк на странице
    $fth = $pnum*$amth-$amth;
    
    $columns_names = array(); // Массив полей таблицы
    // Список полей таблицы
    $columns = $DB->getData("show columns from ".$page); 
    if (is_array($columns)){
      foreach ($columns as $c){
        $columns_names[] = $c['Field'];
        $fields_arr[$c['Field']] = $c['Field'];
      }
      $id = $columns_names[0]; // Первое поле таблицы - ключ ИД
    }
    else{
      die("В базе данных нет таблицы ".$page);
    }
    $fields = $DB->getData("select field, title, class from adm_fields");
    foreach ($fields as $f){
      $fields_values[$f['field']] = $f['title']; // Массив названий столбцов
      $fields_classes[$f['field']] = $f['title']; // Массив классов столбцов
    }
    
    // Запись исформации о сортировке в сессию
    if ($_REQUEST['sort']) $_SESSION['sort'] = $_REQUEST['sort'];
    if ($_REQUEST['sc']) $_SESSION['sc'] = $_REQUEST['sc'];
    // Если есть поле в таблице сортируе по нему
    if ($_SESSION['sort'] && count($DB->getData("select ".$_REQUEST['sort']." from ".$page))){
      $sort = $_SESSION['sort'];
      $sort_exists = '0';
      if ($_SESSION['sort']=='sort') $sort_exists = '1';
    }
    // Иначе сортируем по полю ИД
    else{
      $sort = "$id";
      $sort_exists = '0';
    }
    $sc = $_SESSION['sc'] ? $_SESSION['sc'] : 'desc'; // Порядок сортировки
    $sc_sim = $sc=='asc' ? '&#9660;' : '&#9650;'; // Стрелка сортировки
    $sc_ch = $sc=='asc' ? 'desc' : 'asc';
    
    // Сохранение порядка сортировки строк
    if ($_REQUEST['action']=='sort'){
      $list = explode('&',$_REQUEST['id']);
      //echo "<pre>"; print_r($list); echo "</pre>";
      $s = 1;
      foreach ($list as $l){
        $l_arr = explode('=',$l);
        //echo $l_arr[1]." - $s<br>";
        $DB->query("update $page set sort='$s' where $id='".$l_arr[1]."'");
        $s++;
      }
    }
    // Добавление новой строки (записи)
    if ($_REQUEST['action']=='add'){
      $add_query = "insert $page set level='$level'";
      $add_query .= isset($fields_arr['date']) ? ", date='".date('Y-m-d')."'" : "";
      $DB->query($add_query);
    }
    // Улаление строки (записи)
    if ($_REQUEST['action']=='delete'){
      $del_ids = explode(',', $_REQUEST['id']);
      foreach ($del_ids as $del_id){
        if (!empty($del_id)){
          $DB->query("delete from $page where id='".$del_id."'");
        }
      }
    }
    
    $sql_part = "";
    if (isset($fields_arr['level'])){
      $sql_part .= "level='".$level."' && ";
    }
    if (!empty($filter)){
      $sql_part .= "(".$filter."='".$search."')";
    }
    else{
      $sql_part .= "(title like '%".$search."%'";
      foreach ($fields_arr as $field){
        $sql_part .= "|| ".$field." like '%".$search."%'";
      }
      $sql_part .= ")";
    }
        
    $sql = "select * from ".$page." where ".$sql_part." order by $sort $sc";
    //echo "$sql<hr>";
    $result = $DB->getData($sql." limit $fth, $amth");
    $num_result2 = count($DB->getData($sql));
    $visible_areas = $view_culumns;
    $editable_areas = $edit_culumns;
    
    echo "
    <div>
      <button onClick=\"list_rows('$page','$level','id','desc','$pnum','','','add','0')\" class='form_button'>Добавить запись</button>
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <input type='text' id='search' placeholder='Поиск'>
      <button onClick=\"list_rows('$page','$level','title','asc','1','','','','')\" class='form_button'>Найти</button>
    </div>";
    
    echo "
    <div class='page_list'"; if ($sort_exists) echo " id='sortable'"; echo ">
      <div class='row row_header'>
        <div class='table_header'>&nbsp;</div>
        <div class='table_header'>
          <input type='checkbox' class='check_all'>
        </div>
        <div class='table_header'>
          <a onClick=\"list_rows('$page','$level','".$id."','$sc_ch','$pnum','$filter','$search','','')\" style='cursor:pointer;'>ID &nbsp;";
          if ($sort=="$id") echo "$sc_sim";
        echo "</a>
        </div>";
      foreach ($columns_names as $f){
        if (!in_array($f, $visible_areas)) continue;
        echo "
        <div class='table_header'>
          <a onClick=\"list_rows('$page','$level','".$f."','$sc_ch','$pnum','','','','')\" style='cursor:pointer;'>".$fields_values[$f]." &nbsp;";
          if ($sort==$f) echo "$sc_sim";
        echo "</a>
        </div>";
      }
      echo "
        <div class='table_header'>Удалить</div>
      </div>";
      
    $cnt = 0;
    foreach ($result as $row){
      $image = '/images/interface/blank.gif';
      $cnt++;
      echo "
      <div class='row row_content' id='row_".$row['id']."'>
        <div class='table_content'>";
        if (isset($row['no_edit']) && $row['no_edit']){}
        else{
          echo "
          <a href='table.php?page=$page&fth=$fth&id=".$row['id']."'>
            <i class='fa fa-pencil' aria-hidden='true'></i>
          </a>";
        }
        echo "
        </div>
        <div class='table_content'>
          <input type='checkbox' class='row_check' data-id='".$row['id']."'>
        </div>
        <div class='table_content'>".$row['id']."</div>";
      foreach ($columns_names as $c){
        if (!in_array($c, $visible_areas)) continue; // Пропстить поля, которые не разрешены к показу
        // Формируем превью записи
        $preview = strip_tags($row[$c]);
        $slimit = 150;
        if (strlen($preview)>$slimit){
          $preview = substr($preview,0,$slimit);
          $prev_ar = explode(' ',$preview);
          unset($prev_ar[count($prev_ar)-1]);
          $preview = implode(' ',$prev_ar).'...';
        }
        echo "
        <div class='table_content'>";
        if ($c=='image'){
          if ($page=='gallery_albums'){
            echo "
            <img src='/images/adm_menu/gallery.gif' style='max-width:80px; max-height:80px; cursor:pointer;' onClick=\"$.fancybox.open({type:'iframe', href:'gallery/index.php?id=".$row['id']."', width:1200})\">";
          }
          else{
            $image = $row['image'] ? "/images/$page/".$row['id']."/".$row['image'] : 'images/noimage.png';
            echo "
            <img src='$image' style='max-width:80px; max-height:80px;'>";
          }
        }
        else if ($c=='images'){
          $image = $row['images'] ? "/images/$page/".$row['id']."/small/".$row['images'] : 'images/noimage.png';
          echo "
          <img id='m_image_".$row['id']."' src='$image' style='max-width:80px; max-height:80px; cursor:pointer;' onClick=\"$.fancybox.open({type:'iframe', href:'upload_image.php?page=$page&id=".$row['id']."'})\">";
        }
        else if ($c=='title'){
          $child = $DB->getData("select * from ".$page." where level='".$row['id']."'");
          //echo "<pre>"; print_r($child); echo "</pre>";
          if (is_array($child) && count($child)){
            echo "
            <b><a href='table.php?page=$page&search=$search&level=".$row['id']."'>".stripslashes($row['title'])."</a></b>";
          }
          else if (in_array($c, $editable_areas)){ 
            echo "
            <textarea id='".$c."_".$row['id']."' rows='2' onBlur=\"save_changes('".$c."','$page','".$row['id']."')\" onKeyUp=\"if(event.keyCode=='13'){save_changes('".$c."','$page','".$row['id']."')}\"";
            if (isset($row['no_edit']) && $row['no_edit']) echo " readonly";
            else echo " class='editable'";
            echo ">".$row[$c]."</textarea>";
          }
          else{
            echo $row[$c];
          }
        }
        else if ($c=='date'){
          echo "
          <input type='hidden' id='date_".$row['id']."' value='".$row[$c]."'>
          <label id='date_".$row['id']."_cal'>
            <img src='images/datepicker.gif' style='cursor:pointer;'>
            <input type='text' value='".implode('.',array_reverse(explode('-',$row[$c])))."' style='width:100px;'>
          </label>
          <script type='text/javascript'>
            $(function(){
              $('#date_".$row['id']."_cal').find('input').datepicker({
                altField:'#date_".$row['id']."',
                altFormat:'yy-mm-dd',
                dateFormat:'dd.mm.yy',
                constraintInput:true,
                changeMonth:true,
                changeYear:true,
                onSelect:function(){
                  save_changes('date','$page','".$row['id']."');
                }
              });
              $('#date_".$row['id']."_cal').find('input').mask('99.99.9999');
            });
          </script>";
        }
        else if ($c=='sort'){
          echo "
          <div style='cursor:move; text-align:center;'>".$row[$c]."</div>";
        }
        else if (strstr($c,'sh')){
          echo "
          <label>
            <div class='switch'>
              <input type='checkbox' id='".$c."_".$row['id']."' value='1'"; if ($row[$c]=='1'){ echo " checked"; } echo ">
              <div class='switch_btn'></div>
              <div class='switch_bg'></div>
            </div>
          </label>
          <script type='text/javascript'>
            $(function(){
              $('#".$c."_".$row['id']."').change(function(){ 
                if($('#".$c."_".$row['id']."').is(':checked')){
                  save_changes('".$c."','$page','".$row['id']."','1');
                }
                else{ 
                  save_changes('".$c."','$page','".$row['id']."','0');
                } 
              });
            });
          </script>";
        }
        else if ($c=='adm_alt'){
          echo "
          <div>".nl2br($row[$c])."</div>";
        }
        else{
          if (in_array($c, $editable_areas)){ 
            echo "
            <textarea id='".$c."_".$row['id']."' rows='2' onBlur=\"save_changes('".$c."','$page','".$row['id']."')\" onKeyUp=\"if(event.keyCode=='13'){save_changes('".$c."','$page','".$row['id']."')}\"";
            if (isset($row['no_edit']) && $row['no_edit']) echo " readonly";
            else echo " class='editable'";
            echo ">".$row[$c]."</textarea>";
          }
          else{
            echo "
            $preview";
          }
        }
        echo "
        </div>";
      }
      if (isset($row['no_delete']) && $row['no_delete']){
        echo "
        <div class='table_content'>&nbsp;</div>";
      }
      else{
        echo "
        <div class='table_content'>
          <a onClick=\"if(confirm('Вы действительно хотите удалить эту запись?')){ list_rows('$page','$level','$sort','$sc','$pnum','','','delete','".$row['id']."')}\">
            <i class='fa fa-trash' aria-hidden='true'></i>
          </a>
        </div>";
      }
      echo "
      </div>";
    }
    echo "
    </div>";
    echo "<br>
    <button onClick=\"list_rows('$page','$level','id','asc','$pnum','','','add','0')\" class='form_button'>Добавить запись</button>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <button onClick=\"if(confirm('Вы действительно хотите удалить выбранные записи?')){ delete_rows('$page','$level','$sort','$sc','$pnum','','','delete','')}\" class='form_button2'>Удалить выделнное</button>
    <div class='paginator'>";
    $pages = ceil($num_result2/$amth)+1;
    for ($p=1; $p<$pages; $p++){
      if ($p==$pnum) echo "<div class='paginator_span'><b>$p</b></div>";
      else echo "<div class='paginator_span'><a onClick=\"list_rows('$page','$level','$sort','$sc','$p','$filter','$search','')\" style='cursor:pointer;'>$p</a></div>";
    }
    echo "
    </div>
    <script type='text/javascript'>
      $(function(){
        $('#sortable').sortable({
          items:'.row_content',
          cursor:'move',
          update:function(event,ui){
            sort = $(this).sortable('serialize');
            list_rows('$page','$level','sort','asc','$pnum','','','sort',$(this).sortable('serialize'))
          }
        });
      });
    </script>";
  }
  else{
    echo "Не выбрана таблица.";
  }
?>