<?php
  function removeDir($path) {
    if ($objs = glob($path."/*")) {
      foreach($objs as $obj) {
        is_dir($obj) ? removeDir($obj) : unlink($obj);
      }
    }
    rmdir($path);
  }
  function contentMenu($lev,$mar,$page){
    global $DB, $content_val, $id;
    $margins = array();
    $cnt = 0;
    $content_groups = $DB->getData("select * from $page where level='$lev' order by title"); 
    foreach ($content_groups as $cg){ 
      echo "<option value='".$cg['url']."'";
      if ($content_val==$cg['url']){ echo " selected";}
      echo ">";
      for ($m=0; $m<$mar; $m++){ echo "----";}
      echo $cg['title']."</option>";
      $mar2 = $mar+1;
      contentMenu($cg['id'],$mar2,$page);
      $cnt++;
      if ($cnt>200) break; // Защита от бесконечных циклов
    }
  }
  function levelMenu($lev,$mar,$page){
    global $DB, $level, $id;
    $margins = array();
    $cnt++;
    $levels_groups = $DB->getData("select * from $page where level='$lev' order by sort"); 
    foreach ($levels_groups as $lg){ 
      echo "<option value='".$lg['id']."'";
      if ($level==$lg['id']){ echo " selected";}
      if ($id==$lg['id']){ echo " disabled";}
      echo ">";
      for ($m=0; $m<$mar; $m++){ echo "----";}
      echo $lg['title']."</option>";
      $mar2 = $mar+1;
      levelMenu($lg['id'],$mar2,$page);
      $cnt++;
      if ($cnt>200) break; // Защита от бесконечных циклов
    }
  }
  function levelTitle($lev){
    global $DB;
    global $page;
    global $level_arr;
    $parent = $DB->getData( "select id, title, level from $page where id='$lev'")[0];
    $level_arr[] = "<a href='table.php?page=$page&level=".$parent['id']."'>".$parent['title']."</a>";
    if ($parent['level']) levelTitle($parent['level']);
    return $level_arr;
  }
  function levelURL($id){
    global $DB;
    global $page;
    global $url_arr;
    $parent = $DB->getData("select id, url, level from $page where id='$id'")[0];
    $url_arr[] = "/".$parent[1];
    if ($parent[2]) levelURL($parent[2]);
    return $url_arr;
  }
  function errorLog($err){
    //echo $err;
  }
?>