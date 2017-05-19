<?php

$db=$_GET["q"];
$comm=$db;
$user="root";
$pass="code13";
$server="localhost";
$arr=array();
$count=0;



$conn=mysql_connect($server,$user,$pass);
$check=mysql_select_db($comm,$conn);



$res=mysql_query("SHOW TABLES");


while ($row = mysql_fetch_row($res)) {
   $arr[$count]= $row[0];
    $count++;
   // $count.=$row[0];
}

//echo $arr[0];
echo json_encode($arr);

?>