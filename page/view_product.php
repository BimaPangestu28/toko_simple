<?php

	if (isset($_GET['id'])) {
		$id   =   $_GET['id'];
	} else {
		header("location:index.php");
	}

	if (isset($_SESSION['username'])) {
		$username  =   $_SESSION['username'];

		$auth      =   mysqli_fetch_array(mysqli_query($dbcon, "SELECT * FROM user WHERE username='$username'"));
		$user_id   =  $auth['id'];
	}

	$show     =   mysqli_fetch_array(mysqli_query($dbcon, "SELECT * FROM product INNER JOIN category ON product.category_id=category.id_category WHERE id=$id"));

?>

<h3><?=$show['nama_product'] ?></h3>
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

<div class="box-img view-img">
	<img src="images/<?=$show['gambar_product'] ?>">
</div>
<br>
<p>Category <b><?=$show['category_barang'] ?></b></p>
<p>Stok Product <b><?=$show['stok_product'] ?></b></p>
<p>Harga Product <b>Rp. <?=$show['harga_product'] ?></b></p>
<p><?=$show['deskripsi_product'] ?></p><br><br><br>

<div class="form-group">
	<h4>Beli Barang</h4>
	<hr>

	<form method="POST">
		<div class="form-group">
			<label>Jumlah Beli</label>
			<?php
				if ($show['stok_product'] == 0) {
			?>
				<div class="alert alert-danger">
					<p>Stok Barang Habis</p>
				</div>
			<?php
				} else {
			?>
				<input class="form-control" type="number" name="jumlah_beli" value="1" min="1" max="<?=$show['stok_product'] ?>"><br>
				<button type="submit" class="btn btn-primary btn-sm form-control" name="beli">Beli Product</button>
			<?php
				}
			?>
		</div>
	</form>
</div><br><br>

<?php

	if (isset($_POST['beli'])) {
		$jumlah_beli =  $_POST['jumlah_beli'];

		if ($jumlah_beli < $show['stok_product']) {
			$beli   =   mysqli_query($dbcon, "INSERT INTO chart(user_id, product_id, jumlah, keterangan) VALUES('$user_id', '$id', '$jumlah_beli', 'waiting')");

			if ($beli) {
				mysqli_query($dbcon, "UPDATE product SET stok_product = stok_product - '$jumlah_beli' WHERE id=$id");
				echo "<meta http-equiv='refresh' content='1'>";
			}
		} else {
			echo "<div class='alert alert-danger'><p>Stok Tidak Cukup</p></div>";
		}
	}

?>

<div class="form-group">
	<h4>Comment & Beri Rating</h4>
	<hr>

	<?php
		if (isset($_SESSION['username'])) {
	?>
		<form method="POST">
			<div class="form-group">
				<label>Comment</label>
				<textarea name="comment" class="form-control" rows="5"></textarea>
			</div>

			<div class="form-group">
				<label>Rating (Max. 6)</label>
				<input type="number" name="rating" class="form-control" value="1" min="1" max="6">
			</div>

			<button type="submit" name="submit_comment" class="form-control btn btn-primary btn-sm">Submit Comment</button>
		</form>
	<?php
		} else {
	?>
		<div class="alert alert-danger">
			<p>Silahkan Login Dulu Sebelum Comment. <a href="?page=login">Login Page</a></p>
		</div>
	<?php
		}
	?>
</div><br><br><br>

<?php

		if (isset($_POST['submit_comment'])) {
			$comment   =  $_POST['comment'];
			$rating    =  $_POST['rating'];

			$comment   =  mysqli_query($dbcon, "INSERT INTO comments(comment, user_id, product_id, rating) VALUES('$comment', '$user_id', '$id', '$rating')");
			if ($comment) {
				echo "<meta http-equiv='refresh' content='1'>";
			} else {
				echo "Failed Comment";
			}
		}

	$cshows   =   mysqli_query($dbcon, "SELECT * FROM comments INNER JOIN user ON comments.user_id=user.id WHERE product_id=$id");
	foreach ($cshows as $cshow) {
	
	?>

	<div class="form-group panel">
		<h3><?=$cshow['username'] ?></h3>
		<p style="margin:0"><?=$cshow['comment'] ?></p>
		<p style="margin-top:0">	
			<?php
				for($i=0;$i<$cshow['rating'];$i++)
				{
					echo "&bigstar;";
				}
			?>
		</p>
	</div> <br><br>

<?php

	}

?>