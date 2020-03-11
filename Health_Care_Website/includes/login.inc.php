<?php

//If the button login-submit has been pressed, it will check the database for a user with
// the same username/email and match the hashed password

	if (isset($_POST['login-submit'])){
		require'dbh.inc.php';
		
		$mailuid = $_POST['mailuid'];
		$password = $_POST['pwd'];
		
		if (empty($mailuid) || empty($password)){
			header("Location: ../index.php?error=emptyfields");
			exit();
		}
		else{
			$sql = "SELECT * FROM users WHERE uidUsers = ? OR emailUsers = ?;";
			$stmt = mysqli_stmt_init($conn);
			if (!mysqli_stmt_prepare($stmt, $sql)){
				header("Location: ../index.php?error=sqlerror");
				exit();
			}
			else{
				//Allow user to login with either username or email address
				mysqli_stmt_bind_param($stmt, "ss", $mailuid, $mailuid);
				mysqli_stmt_execute($stmt);
				$result = mysqli_stmt_get_result($stmt);
				if ($row = mysqli_fetch_assoc($result)){
					$pwdCheck = password_verify($password, $row['pwdUsers']);
					if ($pwdCheck == false){
						header("Location: ../index.php?error=wrongpassword");
						exit();
					}
					else if($pwdCheck == true){
						//Session begins with true password, website can be variable based on current User
						session_start();
						$_SESSION['userId'] = $row['idUsers'];
						$_SESSION['userUid'] = $row['uidUsers'];
						
						header("Location: ../index.php?login=success");
						exit();
					}
					else {
						header("Location: ../index.php?error=wrongpassword");
						exit();
					}
				}
				else {
					header("Location: ../index.php?error=nouser");
					exit();
				}
			}
		}
	}
	
	else {
		header("Location: ../index.php");
		exit();
	}