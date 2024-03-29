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
		   "parentLabel" => "root",
		   "action"      => "",
		   "newCat"      => 0,
		   "grandparentLabel" => "",
                   "grandparentID"    => 0,
		   "description" => ""
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

  if($action == "new") {
#  print "action $action";
    if($_SESSION['handle'] ) {
      
      $sql = "INSERT INTO catTree SET label = '$newCat', parent=$parentID";
#print $sql;
      
    $result = sql_query($link,$sql);
    


    $_SESSION['handle']  = 0;
    } else {
#    print "no handle";
    }
  } else if ($action == "edit"){
	  $sql = "update catTree set label = '$parentLabel',description='$description' where id = $parentID";
	  print $sql;
	  $result = sql_query($link,$sql);
	  
  } else {
    $_SESSION['handle'] = 1;

  }

 } else {
  $_SESSION['handle'] = 1;

 }

$ancestors = array();

if(!empty($parentID)) {

  $sql = "select parent,label,description from catTree where id = $parentID";

  #print $sql;

  list($grandparentID,$parentLabel,$description) = getOneArray($sql);


  $sql = "select label from catTree where id = $grandparentID";

#  print $sql;

  $grandparentLabel = getOne($sql);

  
  $ancestors = getAncestors($parentID);
  
  


  /*$ancestor_array = array();


  foreach($ancestors as $ancestor) {

    $ancestor_array[] = "<a href='hierarchie.php?parentId=".$ancestor[0]."'>".$ancestor[1]."'(".$ancestor[0].")</a>";
 
  }

  #print_r($ancestor_array);

  $ancestor_string = implode("=>",$ancestor_array);

 */
}

$sql = "select id, label from catTree where parent = $parentID";
#print "$query";

$items = array();
$result = sql_query($link,$sql);

if($result) {

  while($row = sql_fetch_row($result)) {
    list($id,$label) = $row;
    
    $items[] = array("id"    => $id,
		     "label" => $label);
  }
 } else {
  print sql_error();
 }




$params = array("items"    => $items,
                "handle"          => $_SESSION['handle'],
		"parentLabel"     => $parentLabel,
		"description"     => $description,
                "parentID"              => $parentID,
		"link"            => $PHP_SELF,
		"grandparentID"   => $grandparentID,
		"grandparentLabel" => $grandparentLabel,
		"ancestors" => $ancestors,
     );

#print_r($params);

echo new div('hierarchie.tpl', $params);

function getAncestors($id) {
  
  

  $sql = "SELECT label from catTree where id = $id";


  $label = getOne($sql);
  
  if(empty($label)) {
	  $label = 'root';
  }

  $pair = array('id' => $id,
                'label' => $label);

  if($id == 0) {
    return array($pair);

  } else {
    
	$sql = "SELECT parent FROM catTree where id=$id";
    $parentID = getOne($sql);
	
    $ancestors = getAncestors($parentID);

    array_push($ancestors,$pair);

    return $ancestors;

  }

}


 