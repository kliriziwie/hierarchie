<?php

function makeWikiWord($itemName) {


    $wikiName = "Task" . ucfirst($itemName);
    $wikiName = str_replace(" ", "", $wikiName);
    $wikiName = str_replace(".", "", $wikiName);
    $wikiName = str_replace("-", "", $wikiName);
    $wikiName = str_replace("ä", "ae", $wikiName);
    $wikiName = str_replace("ö", "oe", $wikiName);
    $wikiName = str_replace("ü", "ue", $wikiName);
    return $wikiName;
}

function connectDb($db_name = "tasks", $db_user = 'taskuser', $db_password = 'shopping') {
    global $link;

    $db_host = 'brockman';
    $db_password = 'shopping';
    if (file_exists('db.ini')) {
        $ini_hash = parse_ini_file('db.ini');
        $db_host = $ini_hash['db_host'];
        $db_user = $ini_hash['db_user'];
        $db_password = $ini_hash['db_password'];
    }

    $link = sql_connect($db_host, $db_user, $db_password);

    sql_select_db($link, $db_name);

    return $link;
}

function getTime($itemID, $endDate = 0) {
    global $link;
    $query = "select itemDuration,succID FROM liste WHERE itemID=" . $itemID;

    if ($endDate) {
        $query .= " AND actionTime <= '" . $endDate . "'";
    }
    print $query . "<br>";
    $result = mysqli_query($link, $query);

    $data = mysqli_fetch_row($result);
    list($itemDuration, $succID) = $data;

    if ($succID > 0) {
        $subDuration = getTime($succID, $endDate);
        $itemDuration += $subDuration;
    }

    return $itemDuration;
}

function getOneArray($sql) {
    global $link;

    $result = mysqli_query($link, $sql);
    if (!$result) {
        print $sql . "<br>";
    }
    $array = mysqli_fetch_row($result);

    return $array;
}

function getOneRow($sql) {

    global $link;
    $result = mysqli_query($link, $sql);
    if (!$result) {
        print $sql . "<br>";
    }
#print $sql."<br>";
    $array = mysqli_fetch_assoc($result);

    return $array;
}

function computeCurrentDueTime($taskID, $taskPeriod) {


    $getLastSql = "SELECT taskSeconds FROM journal WHERE taskID=$taskID ORDER"
            . " BY taskSeconds DESC LIMIT 1";
    $last = getOne($getLastSql);

    $due_date_time = $last + $taskPeriod * 60;

    return $due_date_time;
}

function getOne($sql) {
    global $link;
    $result = mysqli_query($link, $sql);
    if (empty($result)) {
        print($sql);
    }
    $array = mysqli_fetch_row($result);

    /* print $sql;
      print_r($array);
      print "<br>"; */
    if (is_array($array)) {
        return $array[0];
    } else {

        return null;
    }
}

function computeNewPeriod($taskID, $newDate) {


    $getLastSql = "SELECT taskSeconds FROM journal WHERE taskID=$taskID ORDER"
            . " BY taskSeconds DESC LIMIT 1";

    $last = getOne($getLastSql);

    $newPeriod = ($newDate - $last) / 60;

    return $newPeriod;
}

function getTaskPeriod($taskID, $taskInfos = null) {

    if ($taskId) {

        $sql = "SELECT * FROM tasks WHERE taskID = $taskID";

        $taskInfos = getOneRow($sql);
    }


    if ($taskInfos['taskPeriodAlt'] > 0) {

        return $taskInfos['taskPeriodAlt'];
    } else {
        return $taskInfos['taskPerod'];
    }
}

function sql_connect($db_host, $db_user, $db_password) {


    if (use_mysqli()) {
        $link = mysqli_connect($db_host, $db_user, $db_password);
    } else {

        $link = mysql_connect($db_host, $db_user, $db_password, false, MYSQL_CLIENT_COMPRESS);
    }

    return $link;
}

function use_mysqli() {

    static $use_mysql_i = null;

    if (!isset($use_mysql_i)) {

        $use_mysql_i = !function_exists('mysql_connect');
    }

    return $use_mysql_i;
}

// eoFkt use_mysqli

function sql_select_db($link, $db_name) {
    if (use_mysqli()) {

        mysqli_select_db($link, $db_name);
    } else {

        mysql_select_db($db_name, $link);
    }
}

function sql_query($link, $sql) {

    if (use_mysqli()) {
        $mysql_result = mysqli_query($link, $sql);
    } else {
        $mysql_result = mysql_query($sql, $link);
    }

    return $mysql_result;
}

function sql_fetch_array($mysql_result) {


    if (use_mysqli()) {
        $data = mysqli_fetch_array($mysql_result);
    } else {
        $data = mysql_fetch_array($mysql_result);
    }
    return $data;
}

function sql_fetch_row($mysql_result) {


    if (use_mysqli()) {
        $data = mysqli_fetch_row($mysql_result);
    } else {
        $data = mysql_fetch_row($mysql_result);
    }
    return $data;
}

function sql_error($link) {
    return use_mysqli()
         ? mysqli_error($link)
         : mysql_error()
         ;
}
