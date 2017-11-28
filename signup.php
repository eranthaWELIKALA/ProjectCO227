<?php
if(!isset($_POST["memID"]) || !isset($_POST["password"])){
	header ("location:home.php");
}
$memIDStatus=true;
require 'connect.php';

$memID = mysqli_real_escape_string($connect, $_POST['memID']);
$password = mysqli_real_escape_string($connect, $_POST['password']);

$signup_query="SELECT * FROM members_login_details WHERE MembershipID='{$memID}'";

if($is_signup_query_run=mysqli_query($connect,$signup_query)){
			if(mysqli_num_rows($is_signup_query_run) == 1){
				$memIDStatus=false;
				echo '<div class="container" align="center">
						<div class="row">
							<div class="col-md-3"></div>
							<div class="col-md-6">
								<div class="alert alert-info alert-dismissable">
								<strong>Account for this Membership Id, is already created.</strong></div><br>
							</div>
							<div class="col-md-3"></div>
						</div>
					</div>';
			}
}
if(isset($_POST["signup_submit"])){
	$memID = mysqli_real_escape_string($connect, $_POST['memID']);
	$password = mysqli_real_escape_string($connect, $_POST['password']);

	$signup_query="SELECT * FROM members_login_details WHERE MembershipID='{$memID}'";

	if($is_signup_query_run=mysqli_query($connect,$signup_query)){
				if(mysqli_num_rows($is_signup_query_run) == 1){
					$memIDStatus=false;
					echo '<div class="container" align="center">
							<div class="row">
								<div class="col-md-3"></div>
								<div class="col-md-6">
									<div class="alert alert-info alert-dismissable">
									<strong>Account for this Membership Id, is already created.</strong></div><br>
								</div>
								<div class="col-md-3"></div>
							</div>
						</div>';
				}else{
					require 'connect.php';
					$memID = mysqli_real_escape_string($connect, $_POST['memID']);
					$firstname = mysqli_real_escape_string($connect, $_POST['firstname']);
					$lastname = mysqli_real_escape_string($connect, $_POST['lastname']);
					$accepted = mysqli_real_escape_string($connect, 'false');
					$request_query="INSERT INTO signup_requests (MembershipID, Firstname, Lastname, Password, Accepted) VALUES ('$memID', '$firstname', '$lastname', '$password',false)";
					$is_request_query_run=mysqli_query($connect,$request_query);
					if(!$is_request_query_run){
							echo '<div class="container">
										<div class="row">
											<div class="col-md-4"></div>
											<div class="col-md-4">
												<div class="alert alert-danger alert-dismissable">
												<a href="signup.php" class="close" data-dismiss="alert" arial-label="close">&times</a>
												<strong>Your signup request isn\'t sent successfully!</strong></div><br>
											</div>
											<div class="col-md-4"></div>
										</div>
									</div>';		
					}
					header ("location:home.php");
				}
	}
	
}
?>
<html>
<head><title>
<?php
echo "SIGNUP ".$_POST['memID'];
?></title><link href="bootstrap/css/bootstrap.min.css" rel="stylesheet"></head>
<form action="signup.php" method="post">
<p align="center">
<table><div class="container"><div class="row">
<div class="col-md-6" align="right">First Name </div>
<div class="col-md-6" align="right"> <input class="form-control" type="text" name="firstname" required></div></div>
<div class="row"><div class="col-md-6" align="right">Last Name </div>
<div class="col-md-6" align="right"> <input class="form-control" type="text" name="lastname" required></div></div>
<div class="row"><div class="col-md-6" align="right">Membership ID </div>
<div class="col-md-6" align="right"> <input class="form-control" type="text" name="memID" value=<?php if($memIDStatus){echo $_POST['memID'];}else {echo '';}?>></div></div>
<div class="row"><div class="col-md-6" align="right">Password </div>
<div class="col-md-6" align="right"> <input class="form-control" type="password" name="password" value=<?php echo $_POST['password'];?>></div></div>
<div class="row"><div class="col-md-6" align="right">Re-enter Password </div>
<div class="col-md-6" align="right"><input class="form-control" type="password" name="rpassword"></div></div>
<div class="row"><div class="col-md-6" align="right"></div>
<div class="col-md-6" align="right"><input class="form-control" type="submit" value="SIGNUP" name="signup_submit"></div></div></div>
</table></p>
</form>
</html>