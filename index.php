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
		elseif ($phonecount==0) {
			echo '<script>alert("At least 1 phone required");</script>';
		}
		else
		{
			$flag=update($id, $name, $dob, $_POST['email'], $_POST['phone']);
		}

	}
}

$page=1;
$limit=4;
if(isset($_GET['page']) && ctype_digit($_GET['page']))
{
	$page=$_GET['page'];
}
if(isset($_GET['limit']) && ctype_digit($_GET['limit']) && $_GET['limit']>=4)
{
	$limit=$_GET['limit'];
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
                                            if(sizeof($emails)>=0)
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
                                                    
                                                </div>
                                            <?php
                                        	}
                                        	if(sizeof($emails)>=0)
                                        		echo '<center id="plusemail"><i class="fas fa-plus" onclick="addemail();"></i></center></div></div>';
                                        	?>


                                        	<?php
                                            if(sizeof($phones)>=0)
                                            	echo '<div class="row form-group"><div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Phones   </label>
                                                </div><div class="col col-md-9" id="phonelist"><div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-phone"></i>
                                                    </div>
                                                    <input type="text" id="phone" name="phone[]" value="'.$phones[0].'" placeholder="Phone" class="form-control">
                                                    
                                                </div>';
                                            	foreach ($phones as $key => $value) {
                                            		if($key==0)
                                            			continue;
                                            ?>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-phone"></i>
                                                    </div>
                                                    <input type="text" id="phone" name="phone[]" value="<?php echo $value; ?>" placeholder="Phone" class="form-control">
                                                    
                                                </div>
                                            <?php
                                        	}
                                        	if(sizeof($phones)>=0)
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
<div class="col-lg-9">
                                <div class="user-data m-b-30">
                                    <h3 class="title-3 m-b-30">
                                        <i class="zmdi zmdi-account-calendar"></i>Contacts</h3>
                                    <div class="table-responsive table-data" style="height: auto;">
                                    	<form method="post">
                                    		<div class="input-group"><div class="input-group-btn"><button class="btn btn-primary"><i class="fa fa-search"></i> Search</button></div><input onkeyup="search($(this));" type="text" id="myTable_filter" name="input1-group2" placeholder="Name" class="form-control" aria-controls="myTable"></div>
                                        <table class="table" id="myTable" onchange="updaterow();">
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
                                        <div class="dataTables_paginate paging_simple_numbers" id="myTable_paginate"><div class="row" style="width:100%;" id="rwid"><div class="col-md-2" id="tmpid"><select name="myTable_length" aria-controls="myTable" class="" onchange="refresh();"><option value="4" selected>4</option><option value="10">10</option><option value="20">20</option><option value="50">50</option></select></div>

                                        <div class="col-md-10" id="selectid" style="text-align: center;"><nav aria-label="...">
  <ul class="pagination">

    <li class="page-item active"><a class="page-link" href="#">1</a></li>
    <li class="page-item">
      <a class="page-link" href="#">
        2
      </a>
    </li>
    <li class="page-item"><a class="page-link" href="#">3</a></li>

  </ul>
</nav></div></div></div>
                                        <div style="width: 200px; float: right"><a href="/addcontact"><i class="fas fa-user-plus" style="font-size: 2.5em;"></i></a></div>
                                    </form>
                                    </div>
                                </div>
                            </div>
                        </center>

<!--Footer-->

<script>
var rows=$('#myTable').children('tbody').children('tr');

function updaterow()
{
	rows=$('#myTable').children('tbody').children('tr');
	refresh();
}
function pageitem(ele)
{
	try{
		var num=parseInt($(ele).children('a').html(), 10);
		$('.page-item.active').removeClass('active');
		$(ele).addClass('active');
		var curr=parseInt($('.page-item.active').children('a').html(), 10);
		refresh();
	}
	catch (e)
	{
		alert(e);
	}
}

function refresh(){
	$('#myTable').children('tbody').html('');
	var bod=$('#myTable').children('tbody');
	var curr=parseInt($('.page-item.active').children('a').html(), 10);
	var limit=parseInt($('#tmpid').children('select').val(), 10);
	var i=(curr-1)*limit*2;
	var upper=(curr*limit)*2;
	var rem=rows.length;
	var count=1;
	$('.pagination').html('');
    rem=Math.ceil(rem/(limit*2));
	do{

		if(curr==count)
		{
			$('.pagination').append(`<li class="page-item active" ><a class="page-link" href="#">`+count+`</a></li>`);
		}
		else
			$('.pagination').append(`<li class="page-item" onclick="pageitem($(this));"><a class="page-link" href="#">`+count+`</a></li>`);
		count++;
		rem-=1;
		console.log(rem);
	}while(rem>0);
	for(i; i<(rows.length*2) && i<upper; i++)
	{
		$(bod).append(rows[i]);
	}

}


	$(document).ready(function(){
//$('#myTable').DataTable();
  $("#myTable_filter").keyup(function(){
  	var txt=$("#myTable_filter").val();
    $.ajax({url: "/functions/getcontact.php?search="+txt, success: function(result){
    $("#list_contact").html(result);
    //refresh();
  }});
  });
  //$("#myTable_filter").children('label').children('input').keyup();

  //$("#myTable_info").remove();
  //var sele=$('#myTable_length').children('label').children('select');
  //$('#myTable_length').children('label').remove();
  //var select=$('#myTable_paginate').html();
  // $('#myTable_paginate').html('');
  // $('#myTable_paginate').prepend('<div class="row" style="width:100%;" id="rwid"><div class="col-md-2" id="tmpid"></div></div>');
  // $('#tmpid').html(sele);
  // $('#rwid').append('<div class="col-md-10" id="selectid"></div>');
  // $('#selectid').html(select);

  // $('#myTable_filter').replaceWith(`<div class="input-group"><div class="input-group-btn"><button class="btn btn-primary"><i class="fa fa-search"></i> Search</button></div><input onkeyup="search($(this));" type="text" id="myTable_filter" name="input1-group2" placeholder="Name" class="form-control" aria-controls="myTable"></div>`);
  refresh();
  var elems=$('.paginate_button');
  for(var i=0; i<elems.length; i++)
  {
  	$(elems[i]).attr('href', '#');
  }

  $('#tmpid').children('select').attr('onchange', 'refresh();');
});





</script>

<script>

function search(val)
{
	var txt=$(val).val();
    $.ajax({url: "/functions/getcontact.php?search="+txt, success: function(result){
    $("#list_contact").html(result);
	}
});
}

function on() {
  document.getElementById("overlay").style.display = "block";
}

function off() {
  document.getElementById("overlay").style.display = "none";
  window.location='/';
}

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

<?php
if($show)
echo 'on();';
?>
</script>
<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/template/footer.php');
?>