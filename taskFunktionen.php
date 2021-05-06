<?php


function makeWikiWord($itemName) {


    $wikiName = "Task".ucfirst($itemName);
    $wikiName = str_replace(" ","",$wikiName);
    $wikiName = str_replace(".","",$wikiName);
    $wikiName = str_replace("-","",$wikiName);
    $wikiName = str_replace("ä","ae",$wikiName);
    $wikiName = str_replace("ö","oe",$wikiName);
    $wikiName = str_replace("ü","ue",$wikiName);
    return $wikiName;
}
function connectDb($db_name = "tasks",$db_user='taskuser') {
	
  $db_host = 'brockman';
  $db_password = 'shopping';
  if(file_exists('db.ini')) {
	$ini_hash = parse_ini_file('db.ini');
	$db_host = $ini_hash['db_host'];
	$db_user = $ini_hash['db_user'];
	$db_password = $ini_hash['db_password'];
	
	
  }
  
  $link = mysql_connect($db_host,$db_user,'shopping');

  mysql_select_db($db_name,$link);

  return $link;

}
function getTime($itemID,$endDate=0) {
  
  $query = "select itemDuration,succID FROM liste WHERE itemID=".$itemID;

  if($endDate) {
    $query .= " AND actionTime <= '".$endDate."'";
  }
print $query ."<br>";
  $result = mysql_query($query);

  $data = mysql_fetch_row($result);
  list($itemDuration,$succID) = $data;

  
  if($succID > 0) {
    $subDuration = getTime($succID,$endDate);
    $itemDuration += $subDuration;
  }
  
  return $itemDuration;


}

function getOneArray($sql) {


  $result = mysql_query($sql);
  if(!$result) {
    print $sql."<br>";
  }
  $array = mysql_fetch_row($result);

  return $array;

}



function getOneRow($sql) {


  $result = mysql_query($sql);
  if(!$result) {
    print $sql."<br>";
  }
#print $sql."<br>";
  $array = mysql_fetch_assoc($result);

  return $array;

}

function computeCurrentDueTime($taskID,$taskPeriod) {

  
  $getLastSql = "SELECT taskSeconds FROM journal WHERE taskID=$taskID ORDER"
      ." BY taskSeconds DESC LIMIT 1";
  $last = getOne($getLastSql);



  $due_date_time = $last + $taskPeriod * 60;

  return $due_date_time;

}

function getOne($sql) {
  $result = mysql_query($sql);
  if(empty($result)) {
    print($sql);
  }
  $array = mysql_fetch_row($result);
  return $array[0];

}


function computeNewPeriod($taskID,$newDate) {

  
  $getLastSql = "SELECT taskSeconds FROM journal WHERE taskID=$taskID ORDER"
      ." BY taskSeconds DESC LIMIT 1";

  $last = getOne($getLastSql);


 
  $newPeriod = ($newDate - $last) / 60 ;

  

  return $newPeriod ;

}


function getTaskPeriod($taskID,$taskInfos=null) {

  if($taskId) {

    $sql = "SELECT * FROM tasks WHERE taskID = $taskID";

    $taskInfos = getOneRow($sql);

  }


  if($taskInfos['taskPeriodAlt'] > 0) {

    return $taskInfos['taskPeriodAlt'];
  } else {
    return $taskInfos['taskPerod'];
  }
 


}

