<?php
  class ConnectMySQL{
    function __construct(){
      $this->сonnect();
    }
    
    function сonnect(){
      include(__DIR__."/../config.php");
      $this->db_link = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die("Ошибка подключения к базе");
      $this->query($this->db_link, "set names `utf8`");
      mysqli_set_charset($this->db_link, 'utf8');
    }
    
    function getData($sql, $pnum=0, $amount=10){
      if (is_string($sql) && !empty($sql)){
        $sql = str_replace(array(';','"'),'',$sql);
        $this->query_res = mysqli_query($this->db_link, $sql);
        if (!$this->query_res){
          return mysqli_error($this->db_link);
        }
        else if (!mysqli_num_rows($this->query_res)){
          return array();
        }
        else{
          $this->query_data = array();
          $this->query_data_ = array();
          while($row = mysqli_fetch_assoc($this->query_res)){ 
            $this->query_data[] = $row;
          }
          if ($pnum){
            $first_row = $pnum*$amount-$amount;
            $this->query_data_['data'] = array_slice($this->query_data, $first_row, $amount);
            $this->query_data_['count'] = count($this->query_data);
          }
          else{
            $this->query_data_ = $this->query_data;
          }
          return $this->query_data_;
        }
      }
    }
    function query($sql){
      if (is_string($sql) && !empty($sql)){
        //$sql = str_replace(array(';','"'),'',$sql);
        $this->query_res = mysqli_query($this->db_link, $sql);
        if ($this->query_res){
          if (strstr($sql, "insert")){
            // Вернутьь ID поледней записи
            return mysqli_insert_id($this->db_link); 
          }
          else{
            return 'true';
          }
        }
        else{
          return mysqli_error($this->db_link);
        }
      }
    }
  }
  $DB = new ConnectMySQL;
?>