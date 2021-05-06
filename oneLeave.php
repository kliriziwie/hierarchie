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
		   "parentID"    => 0,
                   "leaveID"     => 0,
		   "leaveTitle"  => "",
		   "leaveDescription" => "",
		   "action"      => ""
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


if(!empty($action)) {

  if($action == "update") {
#  print "action $action";
    if($_SESSION['handle'] ) {
      
      $sql = "update leaveTable SET  title= '$leaveTitle', description='$leaveDescription' where leave_id = $leaveID";
print $sql;
      
    $result = mysql_query($sql);
    
# print "result $result";
   print mysql_error();

    $_SESSION['handle']  = 0;
    } else {
#    print "no handle";
    }
  } else {
    $_SESSION['handle'] = 1;

  }

 } else {
  $_SESSION['handle'] = 1;

 }


if(!empty($leaveID)) {

  $sql = "select title,description from leaveTable where leave_id = $leaveID";

  print $sql;

  list($leaveTitle,$leaveDescription) = getOneArray($sql);

  $sql = "select label from catTree where id = $parentID";
  $parentLabel = getOne($sql);

  

 
 }




$params = array("leaveID"         => $leaveID,
		"leaveTitle"      => $leaveTitle,
		"leaveDescription" => $leaveDescription,
                "handle"          => $_SESSION['handle'],
		"parentLabel"     => $parentLabel,
                "parentID"              => $parentID,
     );

#print_r($params);

echo new div('oneLeave.tpl', $params);

