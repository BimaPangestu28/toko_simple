<?php

	if (isset($_SESSION['username'])) {
		header("location:index.php");
	}

?>

<h3>Login Page</h3>
<a href="index.php" class="btn btn-primary btn-sm right">Back To List Product</a>
<a href="?page=register" class="btn btn-warning btn-sm right">Register</a>
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

	<button class="btn btn-primary form-control" type="submit" name="login">LOGIN NOW</button>
</form>

<?php

	if (isset($_POST['login'])) {
		$username   =   $_POST['username'];
		$password   =   md5($_POST['password']);

		$cek_login  =   mysqli_num_rows(mysqli_query($dbcon, "SELECT * FROM user WHERE username='$username' AND password='$password'"));

		if ($cek_login > 0) {
			$cek_role   =   mysqli_fetch_array(mysqli_query($dbcon, "SELECT * FROM user WHERE username='$username_session'"));

			$_SESSION['username']   =   $username;
			$_SESSION['role']		=	$cek_role['role'];
			header("location:index.php");
		} else {
			echo "<script>alert('Username atau password salah')</script>";
		}
	}

?>