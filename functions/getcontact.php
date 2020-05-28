<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/include/include.php');

if(isset($_GET['search']))
{
	echo getcontacts($_GET['search']);
}
?>