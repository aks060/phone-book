<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/include/include.php');

if($_SERVER['REQUEST_METHOD']=='POST')
{
	$flag=0;
	if(isset($_POST['delete']) && ctype_digit($_POST['delete']))
	{
		$id=$_POST['delete'];
		$quer=$db->prepare("DELETE FROM contacts WHERE id = ?");
		$quer->bind_param('i', $id);
		$res=$quer->execute();
		if($res)
		{
			$flag=1;
		}
		else
		{
			$flag=0;
		}
	}

	if(isset($_POST['editid']) && ctype_digit($_POST['editid']))
	{
		$id=$_POST['editid'];
		$name=htmlspecialchars($_POST['name']);
		$dob=htmlspecialchars($_POST['dob']);
		$emailcount=sizeof($_POST['email']);
		$phonecount=sizeof($_POST['phone']);
		if(!ctype_digit($id))
		{
			exit();
		}
		if($name=='' || $dob=='')
		{
			echo '<script>alert("Please Enter Name and DOB");</script>';
		}
		else
		{
			$flag=update($id, $name, $dob, $_POST['email'], $_POST['phone']);
			echo 'update called';
		}

	}
}

$show=0;
$editid='';
if(isset($_GET['edit']) && ctype_digit($_GET['edit']))
{
	$editid=$_GET['edit'];
	$quer=$db->prepare("SELECT * FROM contacts WHERE id = ?");
	$quer->bind_param('i', $editid);
	$quer->execute();
	$get=$quer->get_result();
	if(mysqli_num_rows($get)>0)
	{
		$editshow=$get->fetch_assoc();
		$show=1;

		$quer="SELECT * FROM email WHERE contactid=".$editshow['id'];
		$eget=$db->query($quer);
		$emails=array();
		while($estore=$eget->fetch_assoc())
		{
			array_push($emails, $estore['email']);
		}

		$quer="SELECT * FROM phone WHERE contactid=".$editshow['id'];
		$eget=$db->query($quer);
		$phones=array();
		while($estore=$eget->fetch_assoc())
		{
			array_push($phones, $estore['phone']);
		}
	}
	else
	{
		$show=0;
	}
}

require_once($_SERVER['DOCUMENT_ROOT'].'/template/header.php');
if(isset($flag) && $flag==1)
{
	echo '<script>alert("Success");</script>';
}
else
if(isset($flag) && $flag==0)
{
	echo '<script>alert("Some error occured");</script>';
}
?>

<!-- Body here -->
<style type="text/css">
	.contact:hover{
		opacity: 0.7;
		cursor:pointer;
	}

.contact{
	border:none;
	border-top: 1px solid #f2f2f2;
}
.option{
	border:none;
	border-bottom: 2px solid black;
	display: none;
}

#overlay {
  position: fixed;
  display: none;
  width: 100%;
  height: 100%;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: rgba(0,0,0,0.5);
  z-index: 5;
  cursor: pointer;
}

#text{
  position: absolute;
  top: 50%;
  left: 50%;
  font-size: 50px;
  color: white;
  transform: translate(-50%,-50%);
  -ms-transform: translate(-50%,-50%);
  z-index: 5;
}
</style>
<div id="overlay">
  <center>
  		<div class="col-lg-6" style="padding-top: 3%;">
                                <div class="card">
                                    <div class="card-header">
                                        <strong style="display: inline-block;">Edit</strong> Contact
                                        <div style="font-size: xx-large; display: inline-block; position: absolute; right: 0px; top: 0px;" onclick="off()">X</div>
                                    </div>
                                    <div class="card-body card-block">
                                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                            <div class="row form-group">
                                            <input type="hidden" name="editid" value="<?php echo $editid; ?>">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Name</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="text" id="text-input" name="name" value="<?php echo $editshow['name']; ?>" placeholder="" class="form-control">
                                                    <small class="form-text text-muted">Enter Name</small>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">DOB</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="date" id="text-input" name="dob" value="<?php echo $editshow['dob']; ?>" placeholder="" class="form-control">
                                                    <small class="form-text text-muted">Enter DOB</small>
                                                </div>
                                            </div>
                                            <?php
                                            if(sizeof($emails)>0)
                                            	echo '<div class="row form-group"><div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Emails   </label>
                                                </div><div class="col col-md-9" id="emaillist">';
                                            	foreach ($emails as $key => $value) {
                                            ?>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-envelope"></i>
                                                    </div>
                                                    <input type="email" id="email" name="email[]" value="<?php echo $value; ?>" placeholder="Email" class="form-control">
                                                    <div class="input-group-addon" onclick="$(this).parent().remove();">
                                                            <i class="fas fa-times"></i>
                                                        </div>
                                                </div>
                                            <?php
                                        	}
                                        	if(sizeof($emails)>0)
                                        		echo '<center id="plusemail"><i class="fas fa-plus" onclick="addphone();"></i></center></div></div>';
                                        	?>


                                        	<?php
                                            if(sizeof($phones)>0)
                                            	echo '<div class="row form-group"><div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Phones   </label>
                                                </div><div class="col col-md-9" id="phonelist">';
                                            	foreach ($phones as $key => $value) {
                                            ?>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-phone"></i>
                                                    </div>
                                                    <input type="text" id="phone" name="phone[]" value="<?php echo $value; ?>" placeholder="Phone" class="form-control">
                                                    <div class="input-group-addon" onclick="$(this).parent().remove();">
                                                            <i class="fas fa-times"></i>
                                                        </div>
                                                </div>
                                            <?php
                                        	}
                                        	if(sizeof($phones)>0)
                                        		echo '<center id="plusphone"><i class="fas fa-plus" onclick="addphone();"></i></center></div></div>';
                                        	?>
                                            
                                        
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fa fa-dot-circle-o"></i> Update
                                        </button>
                                        <button type="reset" class="btn btn-danger btn-sm">
                                            <i class="fa fa-ban"></i> Reset
                                        </button>
                                    </div>
                                    </form>
                                </div>
                                
                            </div></center>
</div>
<center>
<div class="col-lg-6">
                                <div class="user-data m-b-30">
                                    <h3 class="title-3 m-b-30">
                                        <i class="zmdi zmdi-account-calendar"></i>Contacts</h3>
                                    <!-- <div class="col col-md-12">
                                                    <div class="input-group">
                                                        <div class="input-group-btn">
                                                            <button class="btn btn-primary">
                                                                <i class="fa fa-search"></i> Search
                                                            </button>
                                                        </div>
                                                        <input type="text" id="search" name="input1-group2" placeholder="Search Name" class="form-control">
                                                    </div>
                                                </div> -->
                                    <div class="table-responsive table-data" style="height: auto;">
                                    	<form method="post">
                                        <table class="table" id="myTable">
                                            <thead>
                                                <tr>
                                            
                                                    <td>Name</td>
                                                    <td>DOB</td>
                                                    <td>Phone</td>
                                                    <td>Email</td>
                                                </tr>
                                            </thead>
                                            <tbody id="list_contact">
                                                    <?php echo getcontacts(''); ?>                                            
                                            </tbody>
                                        </table>
                                    </form>
                                    </div>
                                </div>
                            </div>
                        </center>

<!--Footer-->

<script>
	$(document).ready(function(){
$('#myTable').DataTable();
  $("#myTable_filter").children('label').children('input').keyup(function(){
  	var txt=$("#myTable_filter").children('label').children('input').val();
    $.ajax({url: "/functions/getcontact.php?search="+txt, success: function(result){
    $("#list_contact").html(result);
    $('#myTable').DataTable();
  }});
  });
  $("#myTable_filter").children('label').children('input').keyup();
});
</script>

<script>
function on() {
  document.getElementById("overlay").style.display = "block";
}

function off() {
  document.getElementById("overlay").style.display = "none";
  window.location='/';
}

function addemail()
{
	var plus=document.getElementById('plusemail').innerHTML;
	document.getElementById('plusemail').remove();
	document.getElementById('emaillist').innerHTML+=`<div class="input-group"><div class="input-group-addon"><i class="fa fa-envelope"></i></div><input type="email" id="email" name="email[]" value="" placeholder="Email" class="form-control"><div class="input-group-addon" onclick="$(this).parent().remove();"><i class="fas fa-times"></i></div></div><center id="plusemail">`+plus+'</center>';
}

function addphone()
{
	var plus=document.getElementById('plusphone').innerHTML;
	document.getElementById('plusphone').remove();
	document.getElementById('phonelist').innerHTML+=`<div class="input-group"><div class="input-group-addon"><i class="fa fa-phone"></i></div><input type="text" id="phone" name="phone[]" value="" placeholder="Phone" class="form-control"><div class="input-group-addon" onclick="$(this).parent().remove();"><i class="fas fa-times"></i></div></div><center id="plusphone">`+plus+'</center>';
}

<?php
if($show)
echo 'on();';
?>
</script>
<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/template/footer.php');
?>