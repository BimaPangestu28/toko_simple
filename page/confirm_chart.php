<?php

	if (isset($_SESSION['username'])) {
		$username  =   $_SESSION['username'];

		$auth      =   mysqli_fetch_array(mysqli_query($dbcon, "SELECT * FROM user WHERE username='$username'"));
		$user_id   =  $auth['id'];

		if ($auth['role'] != 1) {
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
		<th>Action</th>
	</tr>
	<?php

		$no  =   1;
		$x   =   mysqli_query($dbcon, "SELECT * FROM chart INNER JOIN user ON chart.user_id=user.id INNER JOIN product ON chart.product_id=product.id WHERE keterangan='waiting'");
		foreach ($x as $y) {

	?>
	<tr>
		<td><?=$no++ ?></td>
		<td><?=$y['nama_product'] ?></td>
		<td><?=$y['username'] ?></td>
		<td>Rp. <?php echo $y['jumlah'] * $y['harga_product']; ?></td>
		<td>
			<form method="POST">
				<button type="submit" name="accept" class="btn btn-primary btn-sm" onclick="return confirm('are you sure?')">Accept</button>
				<button type="submit" name="rejected" class="btn btn-danger btn-sm" onclick="return confirm('are you sure?')">Rejected</button>
				<input type="hidden" name="id" value="<?=$y['id_chart'] ?>">
			</form>
		</td>
	</tr>
	<?php
		}
	?>
</table>

<?php

			if (isset($_POST['accept'])) {
				$id  =  $_POST['id'];
				mysqli_query($dbcon, "UPDATE chart SET keterangan='accept' WHERE id_chart=$id");
				echo "<meta http-equiv='refresh' content='1'>";
			} else if (isset($_POST['rejected'])) {
				$id  =  $_POST['id'];
				mysqli_query($dbcon, "UPDATE chart SET keterangan='rejected' WHERE id_chart=$id");
				echo "<meta http-equiv='refresh' content='1'>";
			}

		?>