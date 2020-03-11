<?php
	require "header.php";
	
?>

	<main>
		<div class="wrapper-main">
			<section class="section-default">
				<h1>Signup</h1>
				<?php
					//Error messages for putting in incorrect information in the fields, pulled from the URL (minus password)
					if (isset($_GET['error'])){
						if ($_GET['error'] == "emptyfields"){
							echo '<p>Fill in all of the fields.</p>';
						}
						else if($_GET['error'] == "invalidmail"){
							echo '<p>Invalid Email</p>';
						}
						else if($_GET['error'] == "invaliduid"){
							echo '<p>Invalid Username</p>';
						}
						else if($_GET['error'] == "passwordcheck"){
							echo '<p>Passwords didnt match</p>';
						}
						else if($_GET['error'] == "invalidmailuid"){
							echo '<p>Invalid Email & Username</p>';
						}
						else if($_GET['error'] == "usertaken"){
							echo '<p>Username is already taken</p>';
						}
						
					}
				?>
				<form action="includes/signup.inc.php" method="post">
					<input type="text" name="uid" placeholder="Username">
					<input type="text" name="mail" placeholder="E-mail">
					<input type="password" name="pwd" placeholder="Password">
					<input type="password" name="pwd-repeat" placeholder="Repeat password">
					<button type="submit" name="signup-submit">Signup</button> 
					
				</form>
			</section>
		</div>
	</main>
	
	
<?php
	require "footer.php";
?>