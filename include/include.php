<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/include/dbconn.php');
define('js_start', '<script>alert("');
define('js_end', '");</script>');


function getcontacts($search)
{
	global $db;
	$search=htmlspecialchars($search);
	$quer=$db->prepare("SELECT * FROM contacts WHERE name LIKE ? ORDER BY name");
	$search=$search.'%';
	$quer->bind_param('s', $search);
	$quer->execute();
	$get=$quer->get_result();
	$contacts=array();
	$out='';
	while($store=$get->fetch_assoc())
	{
		$out.='<tr class="contact" onclick="$(\'#'.$store['id'].'\').toggle();"><td><div class="table-data__info"><h6>'.$store['name'].'</h6></div></td><td><h6>'.$store['dob'].'</h6></td>';
		array_push($contacts, $store['id']);
		$phone="SELECT phone FROM phone WHERE contactid=".$store['id'];
		$eget=$db->query($phone);
		$out.='<td class="contact">';
		while ($estore=$eget->fetch_assoc()) {
			$out.='<h6>'.$estore['phone'].'</h6><br>';
			
		}
		$out.='</td>';
		$email="SELECT email FROM email WHERE contactid=".$store['id'];
		$eget=$db->query($email);
		$out.='<td class="contact">';
		
		while ($estore=$eget->fetch_assoc()) {
			$out.='<h6>'.$estore['email'].'</h6><br>';
			
		}
		
		$out.='</td></tr><tr id="'.$store['id'].'" class="option"><td><button id="d'.$store['id'].'" type="submit" class="btn btn-danger btn-sm deletecontact" name="delete" value="'.$store['id'].'">
                                            <i class="fa fa-ban"></i> Delete
                                        </button></td><td></td><td></td><td><button id="e'.$store['id'].'" class="btn btn-success btn-sm" type="button" onclick="window.location=\'/?edit='.$store['id'].'\';">
                                            <i class="fa fa-dot-circle-o"></i> Edit
                                        </button></td></tr>';
		//$out.='<tr style="border-top: none;"><td>hello</td></tr>';
	}
	return $out;
}


function update($id, $name, $dob, $emails, $phones)
{
	global $db;
	if(ctype_digit($id) && $name!='' && $dob!='')
	{
		$quer="SET autocommit = 0";
		$db->query($quer);
		if($db->query("START TRANSACTION"))
		{
			$quer=$db->prepare("DELETE FROM contacts WHERE id = ?");
			$quer->bind_param('i', $id);
			if($quer->execute())
			{
				return insert($name, $dob, $emails, $phones, 1);
			}
			else
			{
				echo 'failed';
			}
		}
	}
}


function insert($name, $dob, $emails, $phones, $update=0)
{
	global $db;
	$error=0;
	$name=htmlspecialchars($name);
	$dob=htmlspecialchars($dob);
	if($update==0)
	{
		$db->query("SET autocommit = 0");
		$db->query("START TRANSACTION");
	}
		$quer=$db->prepare("INSERT INTO `contacts` (`name`, `dob`) VALUES (?, ?)");
			$quer->bind_param('ss', $name, $dob);
			if($quer->execute())
				{
					$res=$quer->get_result();
					$id=$db->insert_id;
						if(sizeof($emails)>0)
						{
							$count=0;
							$skip=1;
							$quer="INSERT INTO `email` (`contactid`, `email`) VALUES";
							foreach ($emails as $key => $value) 
							{
								if($value=='')
									continue;
								$quer.=" ('".$id."', '".htmlspecialchars($value)."')";
								$skip=0;
								if($count<sizeof($emails)-1)
									$quer.=',';
								$count+=1;
							}
							if($skip==0 && !$db->query($quer))
							{
								echo js_start.'Sorry some error occured'.js_end;
								$error=1;
							}
							
						}

						if(sizeof($phones)>0)
						{
							$count=0;
							$skip=1;
							$quer="INSERT INTO `phone` (`contactid`, `phone`) VALUES";
							foreach ($phones as $key => $value) 
							{
								if($value=='')
									continue;
								$quer.=" ('".$id."', '".htmlspecialchars($value)."')";
								$skip=0;
								if($count<sizeof($phones)-1)
									$quer.=',';
								$count+=1;
							}
							if(!$db->query($quer))
								{
									echo js_start.'Sorry some error occured'.js_end;
									$error=1;
								}
						}
						else
						{
							$error=1;
							echo js_start.'Min one phone number is required'.js_end;;
						}
					
				}
				else
				{
					echo js_start.'Sorry some error occured'.js_end;
					$error=1;
				}

	if($error==1)
					{
						$db->query("ROLLBACK");
					}
	else
	if($error==0)
			$db->query("COMMIT");

	$db->query("SET autocommit = 1");
		
	if($error==0)
		{
			return 1;
		}
	else
		return 0;
	
}
?>