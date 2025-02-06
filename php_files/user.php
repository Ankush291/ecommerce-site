<?php
	include '../config.php';
	// echo '1'; exit;
	if(isset($_POST['create'])){
		$f_name = mysqli_real_escape_string($conn, $_POST['f_name']);
		$l_name = mysqli_real_escape_string($conn, $_POST['l_name']);
		$email = mysqli_real_escape_string($conn, $_POST['email']);
		$password = mysqli_real_escape_string($conn, md5($_POST['password']));
		$mobile = mysqli_real_escape_string($conn, $_POST['mobile']);
		$address = mysqli_real_escape_string($conn, $_POST['address']);
		$city = mysqli_real_escape_string($conn, $_POST['city']);
		

		$sql = "SELECT email FROM user WHERE email = '{$email}'";
		$exist = mysqli_query($conn, $sql);
		if(mysqli_num_rows($exist) > 0){
			echo 'Email Already Exists.'; exit;
		}else{
			$insert_sql = "INSERT INTO user (f_name, l_name, email, password, mobile, address, city)
							VALUES ('{$f_name}', '{$l_name}', '{$email}', '{$password}', '{$mobile}', '{$address}', '{$city}')";
			if(mysqli_query($conn, $insert_sql)){
				$id_sql = "SELECT * FROM user WHERE email = '{$email}'";
				$result = mysqli_query($conn, $id_sql);
				if(mysqli_num_rows($result) > 0){
					foreach($result as $row){
						session_start();
						$_SESSION["user_id"] = $row["user_id"]; /* userid of the user */
						$_SESSION["username"] = $row["f_name"];
						$_SESSION["user_role"] = 'user'; /* for user */
					}
				}
				echo "success"; exit;
			}
		}
		
	}

	if(isset($_POST['login'])){

		$email = mysqli_real_escape_string($conn, $_POST['email']);
		$password = mysqli_real_escape_string($conn, md5($_POST['password']));
		

		$sql = "SELECT * FROM user WHERE email = '{$email}' AND password = '{$password}'";
		$response = mysqli_query($conn, $sql);
		if(mysqli_num_rows($response) > 0){
			
			/* Start the session */
			session_start();
			/* Set session variables */
			foreach($response as $row){
				$_SESSION["user_id"] = $row['user_id']; /* userid of the user */
				$_SESSION["username"] = $row['f_name'];
				$_SESSION["user_role"] = 'user'; /* for user */
			}
			
			echo 'success'; exit;
			
		}
		else{
			echo 'error'; exit;
		}
	}


	if(isset($_POST['user_logout'])){
	    /* Start the session */
	    session_start();
	    /* remove all session variables */
	    session_unset();
	    /* destroy the session */
	    session_destroy();

	    echo 'true'; exit;
	}

	if(isset($_POST["profile"])){

		session_start();
		if(isset($_SESSION["user_id"])){
			$user_id = $_SESSION["user_id"];
			$sql = "SELECT * FROM user WHERE user_id = {$user_id}";
			$result = mysqli_query($conn, $sql);
			$output = "";
			if (mysqli_num_rows($result) > 0){
				foreach($result as $row){
					$output .= '<table class="table table-bordered table-responsive">
									<tr>
										<td><b>First Name:</b></td>
										<td>'. $row["f_name"] .'</td>
									</tr>
									<tr>
										<td><b>Last Name:</b></td>
										<td>'. $row["l_name"] .'</td>
									</tr>
									<tr>
										<td><b>Email:</b></td>
										<td>'. $row["email"] .'</td>
									</tr>
									<tr>
										<td><b>Mobile:</b></td>
										<td>'. $row["mobile"] .'</td>
									</tr>
									<tr>
										<td><b>Address:</b></td>
										<td>'. $row["address"] .'</td>
									</tr>
									<tr>
										<td><b>City:</b></td>
										<td>'. $row["city"] .'</td>
									</tr>
								</table>';
				}
			}
			else{
				$output .= '<div class="empty-result">
								No user found.
							</div>';
			}

			echo $output;
		}
		else{
			header("location:".$hostname);
		}
	}

	if(isset($_POST['update'])){

		$f_name = mysqli_real_escape_string($conn, $_POST['f_name']);
		$l_name = mysqli_real_escape_string($conn, $_POST['l_name']);
		$mobile = mysqli_real_escape_string($conn, $_POST['mobile']);
		$address = mysqli_real_escape_string($conn, $_POST['address']);
		$city = mysqli_real_escape_string($conn, $_POST['city']);


		if(!session_id()){
			session_start();
		}
		$user_id = $_SESSION['user_id'];
		$update_sql = "UPDATE user SET f_name = '{$f_name}', l_name = '{$l_name}', mobile = '{$mobile}', address = '{$address}', city = '{$city}' WHERE user_id = {$user_id}";
		
		if(mysqli_query($conn, $update_sql)){
			echo "success"; exit;
		}
			
	}

	if(isset($_POST['modifyPass'])){

		$old = mysqli_real_escape_string($conn, md5($_POST['old_pass']));
		$new = mysqli_real_escape_string($conn, md5($_POST['new_pass']));

		if(!session_id()){ session_start(); }

		$user_id = $_SESSION['user_id'];

		$sql = "SELECT * FROM user WHERE user_id = {$user_id} AND password = '{$old}'";
		$exist = mysqli_query($conn, $sql);

		if(mysqli_num_rows($exist) > 0){
			$update_sql = "UPDATE user SET password = '{$new}' WHERE user_id = {$user_id}";
			if(mysqli_query($conn, $update_sql)){
				echo "success"; exit;
			}else{
				echo 'Password not changed.'; exit;
			}

		}else{
			echo 'Old Password is not matched.'; exit;
		}
	}


?>