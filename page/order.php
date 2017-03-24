<?php

	if (isset($_SESSION['username'])) {
		$username  =   $_SESSION['username'];

		$auth      =   mysqli_fetch_array(mysqli_query($dbcon, "SELECT * FROM user WHERE username='$username'"));
		$user_id   =  $auth['id'];

		if ($auth['role'] != 2) {
			header("location:index.php");
		}
	} else {
		header("location:index.php");
	}

	if (isset($_GET['id'])) {
		$id   =   $_GET['id'];
	} else {
		header("location:index.php");
	}

	$product   =   mysqli_fetch_array(mysqli_query($dbcon, "SELECT * FROM chart INNER JOIN product ON chart.product_id=product.id WHERE id_chart=$id"));

?>

<h3>Order Chart</h3>
<a href="index.php" class="btn btn-primary btn-sm right">Back To List Product</a>
<?php
	if (isset($_SESSION['username'])) {
		echo "<a href='#' class='btn btn-warning btn-sm right'>" . $_SESSION['username'] . "</a>";
	} else {
?>
		<a href="?page=login" class="btn btn-warning btn-sm right">Login</a>
<?php
	}
?>
<hr>

<form method="POST">
	<div class="form-group">
		<label>Alamat</label>
		<textarea name="alamat" class="form-control"></textarea>
	</div>

	<div class="form-group">
		<label>Nomer Telephone</label>
		<input type="number" name="nomer" class="form-control">
	</div>

	<button type="submit" class="btn btn-primary btn-sm form-control" name="order" onclick="return confirm('Apakah anda yakin? Product yang sudah diorder tidak bisa dibatalkan loh')">Order Now</button>
</form>

<?php

	if (isset($_POST['order'])) {
		$alamat      =   $_POST['alamat'];
		$nomer       =   $_POST['nomer'];
		$id_product  =   $product['id'];
		$jum_order   =   $product['jumlah'];

		$order       =   mysqli_query($dbcon, "INSERT INTO orders(user_id, product_id, date_order, address, number_phone, jumlah_order) VALUES('$user_id', '$id_product', now(), '$alamat', '$nomer', '$jum_order')");

		if ($order) {
			mysqli_query($dbcon, "DELETE FROM chart WHERE id_chart=$id");
			header("location:?page=chart");
		}
	}

?>