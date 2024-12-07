<HTML>
<HEAD>
  <title>Администрирование</title>
  <meta http-equiv="Cache-Control" content="no-cache">
  <link rel="stylesheet" href="css/jquery-ui.css">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css">
  <script src="js/jquery.min.js"></script>
  <script src="js/jquery-ui.js"></script>
  <script src="js/jquery.ui.datepicker-ru.js"></script>
  <script src="js/jquery.maskedinput.min.js"></script>
  <script src="js/main.js"></script>
  <script src='js/tinymce/tinymce.min.js' referrerpolicy="origin"></script>
  <script>
    tinymce.init({
      selector: '.tinymce_class',
      plugins: [
          "advlist autolink lists link image preview anchor",
          "code fullscreen save textcolor colorpicker charmap nonbreaking",
          "insertdatetime media table contextmenu paste imagetools"
      ],
      menubar: "edit insert format table",
      toolbar1: "bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist | link unlink anchor | image media | forecolor backcolor  | print preview code ",
      language: 'ru'
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