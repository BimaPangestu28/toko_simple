<?php

	if (isset($_SESSION['username'])) {
		$username_session   =   $_SESSION['username'];
		
		$cek_role   =   mysqli_fetch_array(mysqli_query($dbcon, "SELECT * FROM user WHERE username='$username_session'"));
		if ($cek_role['role'] != 1) {
			header("location:index.php");
		}
	}

	if (isset($_GET['id'])) {
		$id   =  $_GET['id'];

		$xshow   =   mysqli_fetch_array(mysqli_query($dbcon, "SELECT * FROM product INNER JOIN category ON product.category_id=category.id_category WHERE id=$id"));
	} else {
		header("location:index.php");
	}

?>

<h3>Add Product</h3>
<a href="index.php" class="btn btn-primary btn-sm right">Back To List Product</a>
<hr>

<form method="POST" enctype="multipart/form-data">
	<div class="form-group">
		<label>Nama Product</label>
		<input class="form-control" type="text" name="nama_product" value="<?=$xshow['nama_product'] ?>"></input>
	</div>

	<div class="form-group">
		<label>Category Product</label>
		<select class="form-control" name="category_product">
			<option value="<?=$xshow['id_category'] ?>"><?=$xshow['category_barang'] ?></option>
			<?php
				$id_category   =  $xshow['category_id'];
				$x   =    mysqli_query($dbcon, "SELECT * FROM category WHERE id_category != $id_category");
				foreach ($x as $y) {

			?>
			<option value="<?=$y['id_category'] ?>"><?=$y['category_barang'] ?></option>
			<?php

				}

			?>
		</select>
	</div>

	<div class="form-group">
		<label>Stok Product</label>
		<input class="form-control" type="number" name="stok_product" value="<?=$xshow['stok_product'] ?>"></input>
	</div>

	<div class="form-group">
		<label>Harga Product</label>
		<input class="form-control" type="number" name="harga_product" value="<?=$xshow['harga_product'] ?>"></input>
	</div>

	<div class="form-group">
		<label>Deskripsi Product</label>
		<textarea name="deskripsi_product" class="form-control"><?=$xshow['deskripsi_product'] ?></textarea>
	</div>

	<div class="form-group">
		<label>Gambar Product</label>
		<input class="form-control" type="file" name="gambar_product"></input>

		<label>Preview Gambar Product</label>
		<div class="box-img img-edit">
			<img src="images/<?=$xshow['gambar_product'] ?>">
		</div>
	</div>

	<button class="btn btn-primary form-control" type="submit" name="update_product">UPDATE PRODUCT</button>
</form><br><br><br>

<?php

	if (isset($_POST['update_product'])) {
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
		$a = 1;

		if ($a != 1) {
			echo "<script>alert('Form tidak boleh kosong')</script>";
		} else {
			if (move_uploaded_file($tmp_gambar, 'images/' . $name_gambar)) {
				unlink('images/' . $xshow['gambar_product']);
				
				$insert   =   mysqli_query($dbcon, "UPDATE product SET nama_product='$nama_product', category_id='$category_product', stok_product='$stok_product', harga_product='$harga_product', deskripsi_product='$deskripsi_product', gambar_product='$gambar_product' WHERE id=$id");

				if ($insert) {
					move_uploaded_file($tmp_gambar, 'images/' . $name_gambar);
					header("location:index.php");
				} else {
					echo "Error Atas";
				}

			} else {

				$insert   =   mysqli_query($dbcon, "UPDATE product SET nama_product='$nama_product', category_id='$category_product', stok_product='$stok_product', harga_product='$harga_product', deskripsi_product='$deskripsi_product' WHERE id=$id");

				if ($insert) {
					header("location:index.php");
				} else {
					echo "Error Bawah";
				}

			}
		}
	}

?>

