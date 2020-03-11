<?php
	if(isset($_POST['signup-submit'])){
		
		require 'dbh.inc.php';
		
		$username 			= $_POST['uid'];
		$email 					= $_POST['mail'];
		$password 			= $_POST['pwd'];
		$passwordRepeat = $_POST['pwd-repeat'];
		
		//Error handling for signing up with incorrect information. Will return correctly filled information
		// into the URL so the user doesn't need to retype

		if (empty($username) || empty($email) || empty($password) || empty($passwordRepeat)){
			header("Location: ../signup.php?error=emptyfields&uid=".$username."&mail=".$email);
			exit();
		} 
		elseif(!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username)){
			header("Location: ../signup.php?error=invalidmailuid");
			exit();
		}
		elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
			header("Location: ../signup.php?error=invalidmail&uid=".$username);
			exit();
		}
		elseif(!preg_match("/^[a-zA-Z0-9]*$/", $username)){
			header("Location: ../signup.php?error=invaliduid&mail=".$email);
			exit();
		}
		elseif($password !== $passwordRepeat){
			header("Location: ../signup.php?error=passwordcheck&uid=".$username."&mail=".$email);
			exit();
		}

		//No errors found, will execute the code below with the database and insert the users information

		else{
			$sql = "SELECT uidUsers FROM users WHERE uidUsers=?;";
			//Connect to database or give error
			$stmt = mysqli_stmt_init($conn);
			if (!mysqli_stmt_prepare($stmt, $sql)){
				header("Location: ../signup.php?error=sqlerror");
				exit();
			}
			else {
				//Bind the statement into a paramater, execute it to turn to string, reapply to placeholder in SQL code
				mysqli_stmt_bind_param($stmt, "s", $username);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_store_result($stmt);
				//Check if user is taken already
				$resultCheck = mysqli_stmt_num_rows($stmt);
				if ($resultCheck > 0){
					header("Location: ../signup.php?error=usertaken&mail=".$email);
					exit();
				}
				else {
					$sql = "INSERT INTO users (uidUsers, emailUsers, pwdUsers) VALUES (?,?,?)";
					$stmt = mysqli_stmt_init($conn);
					if (!mysqli_stmt_prepare($stmt, $sql)){
						header("Location: ../signup.php?error=sqlerror");
						exit();
					}
					else{
						//Hase the password the user enters and save into the DB, use same method for inserting to DB 
						//as above (param -> execute)
						$hashedPwd = password_hash($password, PASSWORD_DEFAULT);
						
						mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashedPwd);
						mysqli_stmt_execute($stmt);
						header("Location: ../signup.php?signup=success");
						exit();
					}
				}
			}
			
			
		}
		//End statements and close connection
		mysqli_stmt_close($stmt);
		mysqli_close($conn);
		
		
	}
	else {
		header("Location: ../signup.php");
		exit();
	}