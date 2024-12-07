  <div class="breadcrumbs">
  <? foreach ($path as $point){ ?>
    <?=$point?>
  <? } ?>
  </div>
  <h1><?=$header?></h1>
  <? foreach ($fgroups as $group){ ?>
    <div class='fields_headers <?=$group['url']?>_fields_btn' onClick="toggle_fields('<?=$group['url']?>')"><?=$group['title']?></div>
  <? } ?>