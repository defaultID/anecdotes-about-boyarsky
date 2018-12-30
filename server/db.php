<?php
define("MYSQL_SERVER", "localhost");
define("MYSQL_USER", "root");
define("MYSQL_PASSWORD", "");
define("MYSQL_DB", "f0144844_anecdotes_db");

$link = mysqli_connect(MYSQL_SERVER, MYSQL_USER, MYSQL_PASSWORD);
mysqli_select_db($link,MYSQL_DB);
mysqli_query($link,"SET NAMES 'utf-8'");
mysqli_query($link,"SET CHARACTER SET 'utf8'");

function time_format($t) {
    $day = mb_substr("$t",8,2);
    $month = mb_substr("$t",5,2);
    $year = mb_substr("$t",0,4);
    $time = mb_substr("$t",10,-3);
    return $day.".".$month.".".$year.$time;
}