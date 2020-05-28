<?php
require_once('../config.php');
echo shell_exec('mysql --user='.db_user.' --password='.db_pass.' phone.sql');
?>