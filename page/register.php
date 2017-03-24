<?php

	if (isset($_SESSION['username'])) {
		header("location:index.php");
	}

?>

<h3>Register Page</h3>
<a href="index.php" class="btn btn-primary btn-sm right">Back To List Product</a>
<a href="?page=login" class="btn btn-warning btn-sm right">Login</a>
<hr>

<form method="POST">
	<div class="form-group">
		<label>Username</label>
		<input class="form-control" type="text" name="username"></input>
	</div>

	<div class="form-group">
		<label>Password</label>
		<input class="form-control" type="password" name="password"></input>
	</div>

	<div class="form-group">
		<label>Confirm Password</label>
		<input class="form-control" type="password" name="confirm_password"></input>
	</div>

	<button class="btn btn-primary form-control" type="submit" name="register">REGISTER NOW</button>
</form>

<?php

	if (isset($_POST['register'])) {
		$username     =    $_POST['username'];
		$password     =	   md5($_POST['password']);
		$conf_pass 	  =    md5($_POST['confirm_password']);

		$cek_username =    mysqli_num_rows(mysqli_query($dbcon, "SELECT * FROM user WHERE username='$username'"));

		if ($cek_username < 1) {
			if ($password == $conf_pass) {
				$register  =   mysqli_query($dbcon, "INSERT INTO user(username, password, role) VALUES('$username', '$password', 2)");

				if ($register) {
					$cek_role   =   mysqli_fetch_array(mysqli_query($dbcon, "SELECT * FROM user WHERE username='$username_session'"));

					$_SESSION['username']   =   $username;
					$_SESSION['role']		=	$cek_role['role'];
					header("location:index.php");
				}
			} else {
				echo "<script>alert('Password tidak sama')</script>";
			}
		} else {
			echo "<script>alert('Username sudah digunakan')</script>";
		}
	}

?>