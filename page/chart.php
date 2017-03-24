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

?>

<h3>Confirm Chart</h3>
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

<table class="table table-hover">
	<tr>
		<th>No</th>
		<th>Nama Product</th>
		<th>Username Pembeli</th>
		<th>Total Harga Pembelian</th>
		<th>Keterangan</th>
		<th>Action</th>
	</tr>
	<?php

		$no  =   1;
		$x   =   mysqli_query($dbcon, "SELECT * FROM chart INNER JOIN user ON chart.user_id=user.id INNER JOIN product ON chart.product_id=product.id WHERE user_id=$user_id");
		foreach ($x as $y) {

	?>
	<tr>
		<td><?=$no++ ?></td>
		<td><?=$y['nama_product'] ?></td>
		<td><?=$y['username'] ?></td>
		<td>Rp. <?php echo $y['jumlah'] * $y['harga_product']; ?></td>
		<td><?=$y['keterangan'] ?></td>
		<td>
			<form method="POST">
				<a href="?page=order&id=<?=$y['id_chart'] ?>" class="btn btn-primary btn-sm">Order Now</a>
				<button type="submit" name="delete" class="btn btn-danger btn-sm" onclick="return confirm('are you sure?')">Delete Chart</button>
				<input type="hidden" name="id" value="<?=$y['id_chart'] ?>">
			</form>
		</td>
	</tr>
	<?php
		}
	?>
</table>

<?php

			if (isset($_POST['delete'])) {
				$id  =  $_POST['id'];
				mysqli_query($dbcon, "DELETE FROM chart WHERE id_chart=$id");
				echo "<meta http-equiv='refresh' content='1'>";
			}

		?>

<br><br><br>
<h4>Riwayat Pembelian</h4>
<hr>

<table class="table table-hover">
	<tr>
		<th>No</th>
		<th>Nama Product</th>
		<th>Jumlah Order</th>
		<th>Total Harga</th>
		<th>Tanggal</th>
		<th>Action</th>
	</tr>

	<?php

		$x    =   mysqli_query($dbcon, "SELECT * FROM orders INNER JOIN product ON orders.product_id=product.id WHERE user_id=$user_id");
		$no   =   1;
		foreach ($x as $y) {
	
	?>
	<tr>
		<td><?=$no++ ?></td>
		<td><?=$y['nama_product'] ?></td>
		<td><?=$y['jumlah_order'] ?></td>
		<td>Rp. <?=$y['jumlah_order'] * $y['harga_product'] ?></td>
		<td><?=$y['date_order'] ?></td>
		<td>
			<form method="POST">
				<button type="submit" class="btn-danger btn btn-sm" name="delete" onclick="return confirm('Are you sure?')">Hapus Riwayat</button>
				<input type="hidden" name="id" value="<?=$y['id_order'] ?>">
			</form>
		</td>
	</tr>
	<?php
		}
	?>
</table>

<?php

	if (isset($_POST['delete'])) {
		$id_order  =   $_POST['id'];
		mysqli_query($dbcon, "DELETE FROM orders WHERE id_order=$id_order");
		echo "<meta http-equiv='refresh' content='1'>";
	}

?>