<?php
	session_start();
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="description" content="Website for logging in and accessing Health Care CORP database">
		<meta name=viewport content="width=device-width, initial-scale=1">
	</head>
	
	<body>
		<header>
			<nav>
				<ul>
					<li><a href="index.php">Home</a></li>
					<li><a href="#">Portfolio</a></li>
					<li><a href="#">About Me</a></li>
					<li><a href="#">Contact</a></li>
				</ul>
				<div>
				<?php
				//If the user is logged in or not logged in the buttons will change based on that
				//Will hide the login + signup button if logged in
				//Will hide the logout button if logged out
					if (isset($_SESSION['userId'])){
						echo '	<form action="includes/logout.inc.php" method="post">
											<button type="submit" name="logout-submit">Logout</button>
										</form>';
					}
					else {
						echo '	<form action="includes/login.inc.php" method="post">
											<input type="text" name="mailuid" placeholder="Username/E-mail...">
											<input type="password" name="pwd" placeholder="Password">
											<button type="submit" name="login-submit">Login</button>
										</form>
										<a href="signup.php">Signup</a>';
					}
				?>
					
					
				</div>
			</nav>
		</header>
	