<?php
  $url_arr = array();
  $url_arr = array_reverse(levelURL($edit));
  foreach ($url_arr as $u){ echo $u; }
?>