<?php


include "div.php";
include "taskFunktionen.php";

session_start();


$link = connectDb("hierarchie","hierarchieuser");
if(empty($link)) {
  die("no connection");
 }
$PHP_SELF = $_SERVER['PHP_SELF'];
$myGlobals = array(
		   "leaveID"    =>0
	  );


foreach ($myGlobals as $key => $value) {
  if(isset($_REQUEST[$key])) {
    $$key = $_REQUEST[$key];
  } else {
    $$key = $value;
  }

}
#print_r($_REQUEST);
#print_r($_SESSION);
#print_r($myGlobals);


if(!empty($leaveID)) {

 
    $sql = "DELETE FROM leavetable where leave_id =".$leaveID;
      
    print "$sql\n";
    
    $result = sql_query($link,$sql);
    
# print "result $result";
   print sql_error($link);

 
}


$sql = "select count(*) as k, title, description from leavetable group by title,description having k > 1";
#print "$query";

$items = array();
$result = sql_query($link,$sql);

if($result) {

  while($row = sql_fetch_row($result)) {
      list($count,$title,$description) = $row;
      
     $sql = "select leave_id FROM leavetable where title ='". addslashes($title)."' and description = '". addslashes($description)."'";
     
     $subresult = sql_query($link,$sql);
     
     while($subrow = sql_fetch_row($subresult)) {
          list($leave_id) = $subrow;
          $items[] = array("leave_id"    => $leave_id,
		     "title" => AddSlashes($title),
		     "description" => AddSlashes($description));
     }
   
  }
 } else {
  print sql_error();
 }




$params = array("items"    => $items,
     );

#print_r($params);

echo new div('dubbes.tpl', $params);

