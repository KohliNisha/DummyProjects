<?php 

//die("Checking now");
/*
phpinfo();


echo "++++Amit+++++ <br/>";

echo date('Y-m-d h-i-s');
*/
?>
<?php


$filename=$_REQUEST['filename']; 
/*include_once('/home/vul4bhectphl/public_html/smartzitsolutions.com/pieorama/public/getid3/getid3.php');
$filename='/home/vul4bhectphl/public_html/smartzitsolutions.com/pieorama/public/uploads/'.$filename; */

include_once('/home/devpieoramaflexs/public_html/public/getid3/getid3.php');	
$filename='/home/devpieoramaflexs/public_html/public/uploads/'.$filename; 


$getID3 = new getID3;
$file = $getID3->analyze($filename);
echo $file['playtime_string'];
 

/* echo("Duration: ".$file['playtime_string'].
" / Dimensions: ".$file['video']['resolution_x']." wide by ".$file['video']['resolution_y']." tall".
" / Filesize: ".$file['filesize']." bytes<br />"); */  
?>