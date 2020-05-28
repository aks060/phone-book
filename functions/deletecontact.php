<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/include/include.php');
if(isset($_GET['id']))
{
	$id=substr($_GET['id'] ,1);
	if(ctype_digit($id))
	{
		$quer=$db->prepare("DELETE FROM `contacts` WHERE `contacts`.`id` = ?");
		$db->bind_param('d', $id);
		if($db->execute())
		{
			echo '1';
		}
		else
		{
			echo '0';
		}
	}
	echo '0';
}
?>