<?php
header("Content-type: text/csv");
header("Content-Disposition: attachment; filename=salida.csv");
$filename = $_REQUEST['filename'];

$myfile = fopen( $filename, "r") or die("Unable to open file!");
print fread($myfile,filesize($filename));
fclose($myfile); 
unlink( $filename );
?>