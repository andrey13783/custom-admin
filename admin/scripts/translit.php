<?php
function translit($text){
  // Русский алфавит
  $rus_alphabet = array(
        'А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й',
        'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф',
        'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я',
        'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й',
        'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф',
        'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я'
  );
    
  // Английская транслитерация
  $rus_alphabet_translit = array(
        'a', 'b', 'v', 'g', 'd', 'e', 'yo', 'zh', 'z', 'i', 'j',
        'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f',
        'h', 'c', 'ch', 'sh', 'shh', '', 'y', '', 'e', 'yu', 'ya',
        'a', 'b', 'v', 'g', 'd', 'e', 'yo', 'zh', 'z', 'i', 'j',
        'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f',
        'h', 'c', 'ch', 'sh', 'shh', '', 'y', '', 'e', 'yu', 'ya'
  );
    
  $text = str_replace($rus_alphabet, $rus_alphabet_translit, $text);
  $text = str_replace(array(' ','+'), '-', $text);  
  $text = preg_replace ("/[^a-zA-Z0-9\-\.]/","",$text);
  $text = strtolower($text);
  return $text;
}

if (!empty($_REQUEST['t'])){
  echo translit($_REQUEST['t']);
}
?>