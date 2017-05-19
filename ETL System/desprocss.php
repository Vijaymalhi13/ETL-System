<?php

mysql_connect("localhost" , "root" , "code13");



$src=array();
$dst=array();

$SNames = array('1','2','3');
$STypes = array('1','2','3');
$DNames = array('1','2'.'3');
$DTypes = array('1','2','3');



$sourceDB=" ";
$DestDB=" ";
$check1 = 0;

$c=" ";
$counts=0;
$countd=0;

$data = json_decode(stripslashes($_POST['data'])); //sourceTabl
$dat = json_decode(stripslashes($_POST['data1'])); //Dtable
$source=json_decode(stripslashes($_POST['Source'])); //sourceDB
$destination=json_decode(stripslashes($_POST['Dest'])); //DestDB
$method=json_decode(stripslashes($_POST['meth'])); //MethodUse





//  foreach($data as $d){ //source
//     $src[$counts]=$d;
//      $counts++;
//  }
//
//  foreach($dat as $d){ //dest
//    $dst[$countd]=$d;
//      $countd++;
//  }
//




$res = mysql_query("SELECT COUNT(*) as 'Total' FROM INFORMATION_SCHEMA.COLUMNS WHERE table_schema = '$source' AND table_name = '$data'");
while($row = mysql_fetch_assoc($res)){
	$srccol = $row['Total'];
}
$res = mysql_query("SELECT COUNT(*) as 'Total2' FROM INFORMATION_SCHEMA.COLUMNS WHERE table_schema = '$destination' AND table_name = '$dat'");
while($row = mysql_fetch_assoc($res)){
	$destcol = $row['Total2'];
}
if($srccol != $destcol){
	$result = "Error: Columns Not Equal";
}
else{
	$res = mysql_query("SELECT COLUMN_NAME as 'Name',COLUMN_TYPE as 'Type' FROM information_schema.COLUMNS WHERE table_schema='$source' and TABLE_NAME = '$data'");
    $scount=0;
	while($row = mysql_fetch_assoc($res)){
		$SNames[$scount] = $row['Name'];
		$STypes[$scount] = $row['Type'];
        $scount++;
	}
	$res = mysql_query("SELECT COLUMN_NAME as 'Name',COLUMN_TYPE as 'Type' FROM information_schema.COLUMNS WHERE table_schema='$destination' and TABLE_NAME = '$dat'");
    $scount=0;
	while($row = mysql_fetch_assoc($res)){
		$DNames[$scount] = $row['Name'];
		$DTypes[$scount] = $row['Type'];
        $scount++;
	}
	$srcnamelength = count($SNames)-1;
	for($i = 0;$i<$srcnamelength;$i++){
		if(($SNames[$i] != $DNames[$i]) || ($STypes[$i] != $DTypes[$i])){
			$check1 = 1;
		}//end if
	}//end for
	if($check1 == 1){
		$result = "Error: Data Fields Do not Match";
	}//end if
	else{
		mysql_select_db("$destination");
		if($method == "overwrite"){
			mysql_query("DELETE from $dat");
			mysql_query("CREATE TABLE $destination.$dat LIKE $source.$data");
			mysql_query("INSERT INTO $destination.$dat SELECT * FROM $source.$data");
			$result = "Data Transfer Successful";
		}//end if
		else if($method == "append"){
			mysql_select_db("$destination");
			mysql_query("INSERT into $destination.$dat SELECT * from $source.$data ");
			$result = "Data Transfer Successful";
		}//end else if
		else{
			$result = "Error: Not appropriate choice";
		}//end else
	}//end else
}//end else
//	$_SESSION['result'] = $result;






 
//$var=$_GET['q'];
//
//            $dbhost = "localhost";
//             $dbuser = "root";
//             $dbpass = "code13";
//             $dbname = $var;
//			$db = mysql_connect($dbhost,$dbuser,$dbpass);
//            mysql_select_db($var,$db);
//
//           $value=array();
//          // $value=" ";
//           $count=0;
//           // $sql = mysql_query("SELECT Name from employee");
//          //   while($row = mysql_fetch_array($sql))
//           //     {
//            //      $value.=$row['Name'];   
//            //    }
//                    
//
//       $sql = "SHOW TABLES FROM $var";
//       $result = mysql_query($sql);
//      if (!$result) 
//      {
//         echo "DB Error, could not list tables\n";
//         echo 'MySQL Error: ' . mysql_error();
//         exit;
//       }
//
//   while ($row = mysql_fetch_row($result)) {
//   // $value.=$row[0]."\n";
//       $value[$count]=$row[0];
//      $count++;
//}
//
//
//
// echo json_encode($array);
////echo $value;
//
//

echo $result;
?>