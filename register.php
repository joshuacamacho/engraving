<?php
	include("header.php");
	$isinvalid=false;
	$invalid="";
	if(
		isset($_POST['firstname']) && !empty($_POST['firstname']) &&
		isset($_POST['lastname']) && !empty($_POST['lastname']) &&
		isset($_POST['regemail']) && !empty($_POST['regemail']) &&
		isset($_POST['regpassword']) && !empty($_POST['regpassword'])
		){
			require_once("connect.php");
			$firstname=htmlentities(mysqli_real_escape_string($link,$_POST['firstname']));
			$lastname=htmlentities(mysqli_real_escape_string($link,$_POST['lastname']));
			$email=htmlentities(mysqli_real_escape_string($link,$_POST['regemail']));
			$password=sha1(htmlentities(mysqli_real_escape_string($link,$_POST['regpassword'])));

			$allvalid=true;
			
			if(filter_var($email, FILTER_VALIDATE_EMAIL)){
				//IF EMAIL is valid form
				
				$query="SELECT email FROM users WHERE email='".$email."'";
				$result=$link->query($query);
				$row=$result->fetch_array();
				

				if(count($row)>0){
					//if email exists
					$allvalid=false;
					//$invalid.=" This email already exists.";
				}
				else{
					//if email is unique and valid form
					 
				}
			}else{
				//if email is invalid form
				$allvalid=false;
				//$invalid.=" Incorrect email form.";

			}



		 if($allvalid){
			 echo "Registered";
			 $date= date("Y-m-d H:i:s");
			 $query="INSERT INTO users (firstname,lastname,email,password,datejoined) VALUES ('".$firstname."','".$lastname."','".$email."','".$password."','".$date."')";
			 $result=$link->query($query);
			 if (!$result) {
			 $message  = 'Invalid query: ' . mysql_error() . "\n";
		   $message .= 'Whole query: ' . $query;
		   die($message);
		 	 }
			 
			 $isinvalid=false;
		}else{
			$isinvalid=true;
			
		}

			
	}
	if(isset($_POST['firstname'])){
		if(empty($_POST['firstname'])){
			$isinvalid=true;
			$invalid .= " Missing Firstname";
		}else{
			$postfirstname=$_POST['firstname'];
		}
	}
	if(isset($_POST['lastname'])){
		if (empty($_POST['lastname'])){
			$isinvalid=true;
			$invalid .= " Missing Lastname";
		}else{
			$postlastname=$_POST['lastname'];
		}
	}
	if(isset($_POST['regemail'])){
		if(empty($_POST['regemail'])){
			$isinvalid=true;
			$invalid .= " Missing Email";
		}else{
			//$postemailname=$_POST['regemail'];
		}
	}
	if(isset($_POST['regpassword']) && empty($_POST['regpassword'])){
		$isinvalid=true;
		$invalid .= " Missing Password";
	}
	
	if(isset($_POST['regemail']) && !empty($_POST['regemail'])){
		$email=mysqli_real_escape_string($link,$_POST['regemail']);
		if(filter_var($email, FILTER_VALIDATE_EMAIL)){
		//IF EMAIL is valid form
		
		$query="SELECT email FROM users WHERE email='".$email."'";
		$result=$link->query($query);
		$row=$result->fetch_array();
		

		if(count($row)>0){
			//if email exists
			$isinvalid=true;
			$invalid.=" This email already exists.";
		}
		else{
			//if email is unique and valid form
			 $postemail=$_POST['regemail'];
		}
	}else{
		//if email is invalid form
		$allvalid=true;
		$invalid.=" Incorrect email form.";

	}
}
	
	
	echo "
	<div id='content'>
	";
	
	if(!empty($invalid)){
		echo $invalid;
		
	}
	
	echo "<form action='register.php' method='post'>
				<label>First Name</label>
				<input type='text' name='firstname' ";
	if($isinvalid && isset($postfirstname) && !empty($postfirstname)) echo "value='".$postfirstname."' ";
	echo ">";
	echo		"<label>Last Name</label>
				<input type='text' name='lastname' ";
	if($isinvalid && isset($postlastname) && !empty($postlastname)) echo "value='".$postlastname."' ";			
				
	echo		">
				<label>Email</label>
				<input type='text' name='regemail'>
				<label>Password</label>
				<input type='password' name='regpassword'>
				<input type='submit'>
				</form>
				</div>
	";
include("footer.php");
?>
