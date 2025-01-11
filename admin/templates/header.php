<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML>
<HEAD>
  <title>Администрирование</title>
  <meta http-equiv="Cache-Control" content="no-cache">
  <link rel="stylesheet" href="css/jquery-ui.css">
  <link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="js/fancybox/jquery.fancybox.min.css" />
  <link rel="stylesheet" href="css/style.css">
  <script src="js/jquery.min.js"></script>
  <script src="js/jquery-ui.js"></script>
  <script src="js/jquery.ui.datepicker-ru.js"></script>
  <script src="js/jquery.maskedinput.min.js"></script>
  <script src="js/fancybox/jquery.fancybox.min.js"></script>
  <script src="js/main.js"></script>
  <script src='js/tinymce/tiny_mce.js'></script>
  <script>
    tinyMCE.init({
      mode : "specific_textareas",
      editor_selector : "tinymce_class",
      theme : "advanced",
      plugins : "safari,pagebreak,style,layer,table,save,advhr,jbimages,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,noneditable,visualchars,nonbreaking,xhtmlxtras,template,inlinepopups",
      theme_advanced_buttons1 : "formatselect,fontselect,fontsizeselect,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,",
      theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,bullist,numlist,|,link,unlink,anchor,image,jbimages,cleanup,code,|,insertdate,inserttime,|,forecolor,backcolor",
      theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
      theme_advanced_toolbar_location : "top",
      theme_advanced_toolbar_align : "left",
      theme_advanced_statusbar_location : "bottom",
      convert_urls : false
    });
  </script>
</HEAD>
<BODY>

<main>
  <div class="main_menu">
    <div class="sections_title">
      Вы вошли как <?=$adm_user['title']?><br><br>
      <a href="?logout">Выйти</a>
    </div><br>
  <? foreach ($main_menu as $point){ ?>
    <? if ($point['link']){ ?>
    <div class="sections_title" id="show_<?=$point['id']?>_sections" onClick="location.href='<?=$point['link']?>'">
      <h2><a href="<?=$point['link']?>"><?=$point['title']?></a></h2>
    <? }else{ ?>
    <div class="sections_title" id="show_<?=$point['id']?>_sections">
      <h2>
        <i class="fa <?=$point['icon']?>" aria-hidden="true"></i>&nbsp;
        <?=$point['title']?>
      </h2>
    <? } ?>
      <ul class="sections_items sections_<?=$point['id']?>">
    <? foreach ($main_menu[$point['id']]['child'] as $sub_point){ ?>
        <li class="sections_item sections_item_<?=$sub_point['page']?>" onClick="location.href='<?=$sub_point['link']?>'">
          <i class="fa fa-angle-right" aria-hidden="true"></i>&nbsp;
          <a href="<?=$sub_point['link']?>"><?=$sub_point['title']?></a>
        </li>
    <? } ?>
      </ul>
    </div>
  <? } ?>
  </div>
  <div class="content">