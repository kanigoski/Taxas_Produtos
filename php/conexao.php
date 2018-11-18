<?php
header('Content-Type:' . "text/plain");

$host = "localhost";
$user = "postgres";
$pswd = "postgres";
$dbname = "processo_seletivo";
$con = null;

$con = @pg_connect("host=$host user=$user password=$pswd dbname=$dbname") or die (pg_last_error($con));
?>