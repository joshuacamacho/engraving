<?php
	if( isset($_POST['username']) && isset($_POST['password']) ){
		if(!empty($_POST['username']) && !empty($_POST['password']) ){
				require_once('connect.php');
				$username=$_POST['username'];
				$password=$_POST['password'];

				$result = mysql_query("SELECT password FROM users WHERE email='$username'");
				if (!$result) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    //$message .= 'Whole query: ' . $query;
    die($message);
}
				while($row = mysql_fetch_assoc($result)){

				//echo "<pre>".print_r($row)."</pre>";

				if($password == $row['password']){
					//echo "password good";
					header("Location: ./dashboard");
				}else echo "password no good";
			}
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
<title>Admin Login</title>
</head>

<body>
	<form target-"admin.php" method="POST">
		<input name="username" type="text">
		<input name="password" type="password">
		<input type="submit">
	</form>
</body>

</html>