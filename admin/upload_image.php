<?php
  date_default_timezone_set('Europe/Moscow');
  header("Cache-Control: no-store, no-cache, must-revalidate");
  header("Expires: " . date("r"));
  require('config.php');  
  require('inc/mysql.class.php');
  if (empty($_REQUEST['page'])) die("Некорректный запрос");
?>
<meta http-equiv="Cache-Control" content="no-cache">
<title>Загрузка картинок</title>
<link rel="stylesheet" href="js/fancybox/jquery.fancybox.min.css" />
<link rel="stylesheet" href="css/style.css">
<script src="js/jquery.min.js"></script>
<script src="js/jquery-ui.js"></script>
<script src="js/jquery.maskedinput.min.js"></script>
<script src="js/fancybox/jquery.fancybox.min.js"></script>
<script src="js/main.js"></script>
<BODY leftMargin="30" topMargin="10">
<?php
  $id = $_REQUEST['id'];
  $page = $_REQUEST['page'];
  $row = $DB->getData("select * from ".$page." where id='".$id."' limit 1")[0];
  echo "
  <h1>".$row['title']."</h1>";
  $main_image = $row['m_image'];
  if (isset($_REQUEST['sort'])){
    $list = explode('&',$_REQUEST['sort']);
    //echo "<pre>"; print_r($list); echo "</pre>";
    $s = 1;
    foreach ($list as $l){
      $l_arr = explode('=',$l);
      //echo $l_arr[1]." - $s<br>";
      $DB->query("update images set sort='".$s."' where id='".$l_arr[1]."'");
      $s++;
    }
    echo "
    <div class='alt_message'>Картинки отсортированы.</div>";
  }
  if ($_POST){
    include("scripts/translit.php");
    $images = $_FILES['images'];
    $tmp_names = $images['tmp_name'];
    $names = $images['name'];
    $sizes = $images['size'];
    $types = $images['type'];
    $images_num = count($names);;
    for ($i=0; $i<$images_num; $i++){
      $file = $tmp_names[$i];
      $filename = $names[$i];
      $img_array = pathinfo($filename);
      $imgname = $img_array['basename']; 
      $imgtype = $img_array['extension']; 
      $imgname = translit($imgname);
      $filesize = $sizes[$i];
      $filetype = $types[$i];
      if ($filetype=='image/x-png' || $filetype=='image/pjpeg' || $filetype=='image/jpeg' || $filetype=='image/gif' || $filetype=='image/png'){
        if ($filesize<5000000){
          $scr_img = ImageCreateFromJpeg($file);
          $size = GetImageSize($file); 
          $scr_width = $size[0]; 
          $scr_height = $size[1]; 
          if ($scr_width>$scr_height){
            $small_width = "200"; 
            $small_height = ($small_width/$scr_width) * $scr_height;
            if ($scr_width>800){
              $large_width = "800"; 
              $large_height = ($large_width/$scr_width) * $scr_height;
            }
            else{
              $large_width = $scr_width; 
              $large_height = $scr_height;
            }
          }
          else{
            $small_height = "200"; 
            $small_width = ($small_height/$scr_height) * $scr_width;
            if ($scr_height>800){
              $large_height = "800"; 
              $large_width = ($large_height/$scr_height) * $scr_width;
            }
            else{
              $large_height = $scr_height;
              $large_width = $scr_width; 
            }
          }
          // Создаем и загружаем миниатюру
          $small_img = ImageCreateTrueColor($small_width, $small_height); 
          ImageCopyResampled($small_img, $scr_img, 0, 0, 0, 0, $small_width, $small_height, $scr_width, $scr_height); 
          ImageJpeg($small_img, "../images/$page/$id/small/$imgname", 100); 
          ImageDestroy($small_img);
          $large_img = ImageCreateTrueColor($large_width, $large_height); 
          // Создаем и загружаем большую картинку
          ImageCopyResampled($large_img, $scr_img, 0, 0, 0, 0, $large_width, $large_height, $scr_width, $scr_height); 
          ImageJpeg($large_img, "../images/$page/$id/large/$imgname", 100); 
          ImageDestroy($large_img);
          // Добавляем запись в БД
          echo $DB->getData("select * from images where page='$page'&&publ_id='$id'&&file='$imgname'")[0]['count'];
          if (!$DB->getData("select * from images where page='$page'&&publ_id='$id'&&file='$imgname'")[0]['count']){
            $DB->query("insert images set page='$page', publ_id='$id' , file='$imgname'");
          }
        }
        else echo "<div class='alt_message'>$filename - Размер файла не должен превышать 5 Мб.</div>";
      }
      else echo "<div class='alt_message'>$filename ($filetype) - Файл не является картинкой.</div>";
    }
  }
  else if (isset($_GET['delete'])){
    $delete = $_GET['delete'];
    unlink("../images/$page/$id/small/$delete");
    unlink("../images/$page/$id/large/$delete");
    $DB->query("delete from images where file='".$delete." && page='".$page."' && publ_id='".$id."'");
    echo "
    <div class='alt_message'>Картинка $delete удалена.</div>";
  }
  else if (isset($_GET['main'])){
    $main = $_GET['main'];
    $DB->query("update $page set images='".$main."' where id='$id'");
    echo "
    <div class='alt_message'>Картинка $main установлена главной в записи.</div>
    <script>
      window.top.$('#images_$id').attr('src','../images/".$page."/".$id."/small/".$main."');
      window.top.$('#images').val('$main');
    </script>";
  }
  echo "<hr>";
  // Создаём директории, если их ещё нет
  if (!file_exists("../images/".$page."/".$id)){
    mkdir("../images/".$page."/".$id,0777);
  }
  if (!file_exists("../images/".$page."/".$id."/small")){
    mkdir("../images/".$page."/".$id."/small",0777);
  }
  if (!file_exists("../images/".$page."/".$id."/large")){
    mkdir("../images/".$page."/".$id."/large",0777);
  }
  $handle = opendir("../images/$page/$id/small");
  while (false !==($fil = readdir($handle))){ 
    if (stristr($fil,'.jpg') || stristr($fil,'.jpeg')){
      if (!count($DB->getData("select * from images where page='".$page."' && publ_id='".$id."' && file='".$fil."'"))){
        $DB->query("insert images set page='".$page."', publ_id='".$id."' , file='".$fil."'");
      }
    }
  }
  closedir($handle);
  echo "
  <script>
    imgs = '';
  </script>
  <div id='sortable' class='upload_images'>";
  // Считываем изображения из БД
  $img_cnt = 0; // Счётчик изображений
  $images_sql = $DB->getData("select * from images where page='".$page."' && publ_id='".$id."' order by sort");
  foreach ($images_sql as $is){
    // Удаляем из БД картинки, которых нет в директории
    if (!file_exists("../images/".$page."/".$id."/large/".$is['file'])){
      $DB->query("delete from images where id='".$is['id']."'");
    }
    $file = $is['file'];
    echo "
    <div id='image_".$is['id']."'>
      <img src='../images/".$page."/".$id."/small/".$is['file']."' style='max-height:100px; max-width:100px; margin:0 0 10px 0;'><br>
      <label>
        <textarea id='image_".$is['id']."_area' rows='2' placeholder='Текст для подсказки' onBlur=\"save_imagename('".$is['file']."','$page','".$is['id']."','image_".$is['id']."_area')\" style='margin:6px 0; background:#ffffff; resize:none;'>".$is['title']."</textarea>
      </label>
      <div style='position:absolute; top:10px; right:10px;'>
        <img src='images/delete2.gif' onClick=\"if(confirm('Вы действительно хотите удалить этот файл?')){location.href='upload_image.php?page=$page&id=$id&delete=".$is['file']."'}\" style='cursor:pointer;' alt='Удалить картинку'>
        <img src='images/main.png' onClick=\"location.href='upload_image.php?page=$page&id=$id&main=".$is['file']."'\" style='cursor:pointer;' alt='Сделать главной'>
      </div>
    </div>
    <script>
      imgs += \"<img src='../images/$page/$id/small/".$is['file']."' class='images_th' onClick=main_image('../images/$page/$id/small/".$is['file']."','".$is['file']."','$id')>\";
    </script>";
    $img_cnt++;
  }
  // Если одно изображение - делем его главным
  if ($img_cnt==1){
    $DB->query("update $page set m_image='".$file."' where id='".$id."'");
    echo "
    <script>
      window.top.$('#m_image_$id').attr('src','/images/$page/$id/small/$file');
      window.top.$('#m_image').val('$file');
    </script>";
  }
  echo "
  </div>
  <script>
    window.top.$('#img_list').html(imgs);
  </script>
  <hr><br>
  <form id='images_form' action='' method='post' enctype='multipart/form-data'>
    <input type='hidden' name='id' value='$id'>
    <input type='hidden' name='page' value='$page'>
    <label>
      <span id='load_btn' class='form_button'>Загрузить картинки</span>
      <input type='file' name='images[]' multiple='true' accept='image/jpeg' style='visibility:hidden; position:absolute;' onchange=\"$('#load_btn').text('Загрузка...'); $('#images_form').submit();\">
    </label>
    &nbsp;&nbsp;
    <span id='load_btn' class='form_button2' onClick='parent.$.fancybox.close();'>Закрыть окно</span>
  </form>";
  echo "
  <script type='text/javascript'>
    $(function(){
      $('#sortable').sortable({
        cursor:'move',
        update:function(event,ui){
          sort = $(this).sortable('serialize');
          $.get('upload_image.php', { page: '$page', id: '$id', sort: sort }, function(data){
            $('body').html(data); 
          });
        }
      });
    });
  </script>";
?>