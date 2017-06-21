<?php  
  header("Content-Type:text/xml ");
  $f = new SaeFetchurl();
  $data = $f->fetch("http://naples-wordpress.stor.sinaapp.com/submit_log.txt");  
  echo $data;  
?>