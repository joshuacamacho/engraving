<?php
	require_once('../connect.php');
	$result = mysql_query("SELECT * FROM users");
	$row = mysql_fetch_array($result);
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="../css/style.css">
<title>Dashboard Home</title>
</head>

<body>
	<div class="dashboard">

		<div id="dashleft">
			<ul>
				<li><a href="../dashboard">Dashboard</a></li>
				<li><a href="users.php">Users</a></li>
				<li><a href="catalog.php">Catalog</a></li>
			</ul>
		</div>

		<div id="dashmiddle">
			<ul>
			<?php
				foreach ($row as $userdata){
					foreach($userdata['username'] as $user)
					echo "<li>$user</li>";
				}
			?>
			
			</ul>
		</div>

		<div id="dashright">
			main body
		</div>

	</div>
</body>

</html>