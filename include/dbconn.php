<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
$db=mysqli_connect(db_host, db_user, db_pass, db_name);
if(!$db)
die('Cannot connect to database');
?>