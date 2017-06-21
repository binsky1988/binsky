<?php  
  header("Content-Type:text/xml ");
  $f = new SaeFetchurl();
  $data = $f->fetch("http://naples-wordpress.stor.sinaapp.com/sitemap_baidu.xml");  
  echo $data;  
?>