<?php


include "div.php";
include "taskFunktionen.php";

session_start();


print "es wird aufgerufen";


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

print_r($_REQUEST);


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
	
	print "action $action\n";

  if($action == "update") {
#  print "action $action";
    if(true or $_SESSION['handle'] ) {
      
      $sql = "update leaveTable SET  title= '$leaveTitle', description='$leaveDescription' where leave_id = $leaveID";
print $sql;
      
    $result = sql_query($link,$sql);
    
# print "result $result";
   print sql_error($link);

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

  $sql = "select title,description,cat from leaveTable where leave_id = $leaveID";

  print $sql;

  list($leaveTitle,$leaveDescription,$parentID) = getOneArray($sql);

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

