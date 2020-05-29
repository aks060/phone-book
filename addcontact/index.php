<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/include/include.php');

if($_SERVER['REQUEST_METHOD']=='POST')
{
	if(isset($_POST['addcontact']))
	{
		$name=htmlspecialchars($_POST['name']);
		$dob=htmlspecialchars($_POST['dob']);
		$emails=$_POST['email'];
		$phones=$_POST['phone'];
		$ret=insert($name, $dob, $emails, $phones, 0);
		if($ret==1)
		{
			echo '<script>alert("Success");</script>';
		}
	}
}
require_once($_SERVER['DOCUMENT_ROOT'].'/template/header.php');
?>

<center>
  		<div class="col-lg-6" style="padding-top: 3%;">
                                <div class="card">
                                    <div class="card-header">
                                        <strong style="display: inline-block;">Add</strong> Contact
                                    </div>
                                    <div class="card-body card-block">
                                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                            <div class="row form-group">
                                            <input type="hidden" name="addcontact" value="">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Name</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="text" id="text-input" name="name" value="" placeholder="Enter name" class="form-control" required="">
                                                    <small class="form-text text-muted">Enter Name</small>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">DOB</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="date" id="text-input" name="dob" value="" placeholder="Date of Birth" class="form-control">
                                                    <small class="form-text text-muted">Enter DOB</small>
                                                </div>
                                            </div>
                                            <div class="row form-group"><div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Emails   </label>
                                                </div><div class="col col-md-9" id="emaillist">
                                            	<div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-envelope"></i>
                                                    </div>
                                                    <input type="email" id="email" name="email[]" value="" placeholder="Email" class="form-control">
                                                </div>
                                            <center id="plusemail"><i class="fas fa-plus" id="addemail" onclick="addemail();"></i></center></div></div>
                                        	


                                        	<div class="row form-group"><div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Phones   </label>
                                                </div><div class="col col-md-9" id="phonelist">
                                                	<div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-phone"></i>
                                                    </div>
                                                    <input type="text" id="phone" name="phone[]" value="" placeholder="Phone" class="form-control" required="">
                                                </div>
                                            <center id="plusphone"><i class="fas fa-plus" id="addphone" onclick="addphone();"></i></center></div></div>
                                        	
                                            
                                        
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fa fa-dot-circle-o"></i> Save
                                        </button>
                                        <button type="reset" class="btn btn-danger btn-sm">
                                            <i class="fa fa-ban"></i> Reset
                                        </button>
                                    </div>
                                    </form>
                                </div>
                                
                            </div></center>


<script>
	function addemail()
{
	var plus=$('#plusemail').html();
	$('#plusemail').remove();
	$('#emaillist').append(`<div class="input-group"><div class="input-group-addon"><i class="fa fa-envelope"></i></div><input type="email" id="email" name="email[]" value="" placeholder="Email" class="form-control"><div class="input-group-addon" onclick="$(this).parent().remove();"><i class="fas fa-times"></i></div></div><center id="plusemail">`+plus+'</center>');
}

function addphone()
{
	var plus=$('#plusphone').html();
	$('#plusphone').remove();
	$('#phonelist').append(`<div class="input-group"><div class="input-group-addon"><i class="fa fa-phone"></i></div><input type="text" id="phone" name="phone[]" value="" placeholder="Phone" class="form-control"><div class="input-group-addon" onclick="$(this).parent().remove();"><i class="fas fa-times"></i></div></div><center id="plusphone">`+plus+'</center>');
}
</script>
<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/template/footer.php');
?>