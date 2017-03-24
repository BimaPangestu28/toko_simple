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
<a href="index.php" class="btn btn-primary btn-sm right">Back To List Product</a>
<hr>

<form method="POST" enctype="multipart/form-data">
	<div class="form-group">
		<label>Nama Product</label>
		<input class="form-control" type="text" name="nama_product"></input>
	</div>

	<div class="form-group">
		<label>Category Product</label>
		<select class="form-control" name="category_product">
			<?php

				$x   =    mysqli_query($dbcon, "SELECT * FROM category");
				foreach ($x as $y) {

			?>
			<option value="<?=$y['id_category'] ?>"><?=$y['category_barang'] ?></option>
			<?php

				}

			?>
		</select><br>
		<a href="?page=add_category" class="btn btn-warning btn-sm left"> Add Category</a>
	</div><br>

	<div class="form-group">
		<label>Stok Product</label>
		<input class="form-control" type="number" name="stok_product"></input>
	</div>

	<div class="form-group">
		<label>Harga Product</label>
		<input class="form-control" type="number" name="harga_product"></input>
	</div>

	<div class="form-group">
		<label>Deskripsi Product</label>
		<textarea name="deskripsi_product" class="form-control"></textarea>
	</div>

	<div class="form-group">
		<label>Gambar Product</label>
		<input class="form-control" type="file" name="gambar_product"></input>
	</div>

	<button class="btn btn-primary form-control" type="submit" name="add_product">ADD PRODUCT</button>
</form><br><br><br>

<?php

	if (isset($_POST['add_product'])) {
		$nama_product      =    $_POST['nama_product'];
		$category_product  =    $_POST['category_product'];
		$stok_product      =    $_POST['stok_product'];
		$harga_product     =    $_POST['harga_product'];
		$deskripsi_product =    $_POST['deskripsi_product'];
		$gambar_product    =    $_FILES['gambar_product']['name'];
		$tmp_gambar        =    $_FILES['gambar_product']['tmp_name'];

		$extension         =    new SplFileInfo($gambar_product);
		$extension         =    $extension->getExtension();
		$name_gambar       =    str_replace(" ", "-", $nama_product . '.' . $extension);

		if ($nama_product == '' || $nama_product == null || category_product == '' || category_product == null || stok_product == '' || stok_product == null || harga_product == '' || harga_product == null || deskripsi_product == '' || deskripsi_product == null || $gambar_product == '' || $gambar_product == null) {
			echo "<script>alert('Form Tidak Boleh Kosong')</script>";
		} else {
			if (move_uploaded_file($tmp_gambar, 'images/' . $name_gambar)) {
				
				$insert   =   mysqli_query($dbcon, "INSERT INTO product(nama_product, category_id, stok_product, harga_product, deskripsi_product, gambar_product) VALUES('$nama_product', '$category_product', '$stok_product', '$harga_product', '$deskripsi_product', '$name_gambar')");

				if ($insert) {
					header("location:index.php");
				} else {
					echo "Error";
				}

			}
		}
	}

?>

