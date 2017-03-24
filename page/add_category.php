<?php

	if (isset($_SESSION['username'])) {
		$username_session   =   $_SESSION['username'];
		
		$cek_role   =   mysqli_fetch_array(mysqli_query($dbcon, "SELECT * FROM user WHERE username='$username_session'"));
		if ($cek_role['role'] != 1) {
			header("location:index.php");
		}
	}

?>

<h3>Add Product</h3>
<a href="?page=add_category" class="btn btn-primary btn-sm right">Back To Add Product</a>
<hr>

<form method="POST">
	<div class="form-group">
		<label>Nama Category</label>
		<input type="text" name="nama_category" class="form-control">
	</div>

	<button class="btn btn-primary btn-sm form-control" type="submit" name="submit_category">Add Category</button>
</form>

<?php

	if (isset($_POST['submit_category'])) {
		echo "Submit";
		$nama_category   =   $_POST['nama_category'];

		$insert          =   mysqli_query($dbcon, "INSERT INTO category(category_barang) VALUES('$nama_category') ");

		if ($insert) {
			header("location:?page=add_product");
		} else {
			echo "Error";
		}
	}

?>