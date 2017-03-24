<h3>List Product</h3>
<?php

	if (isset($_SESSION['username'])) {
		echo "<a href='?page=logout' class='btn btn-danger btn-sm right'>Logout</a>";
		echo "<a href='#' class='btn btn-primary btn-sm right'>" . $_SESSION['username'] . "</a>";

		$username_session   =   $_SESSION['username'];
		
		$cek_role   =   mysqli_fetch_array(mysqli_query($dbcon, "SELECT * FROM user WHERE username='$username_session'"));

		$cek_chart  =   mysqli_num_rows(mysqli_query($dbcon, "SELECT * FROM chart WHERE keterangan='waiting'"));
		if ($cek_role['role'] == 1) {
			echo "<a href='?page=add_product' class='btn btn-warning btn-sm right'>Add Product</a>";
			echo "<a href='?page=confirm_chart' class='btn btn-danger btn-sm right'>Confirm Chart (" . $cek_chart . ")</a>";
		} else {
			echo "<a href='?page=chart' class='btn btn-warning btn-sm right'>Chart</a>";
		}
	} else {
		echo "<a href='?page=login' class='btn btn-primary btn-sm right'>LOGIN</a>";
	}

?>
<hr>

<table class="table table-hover">
	<tr>
		<th>No</th>
		<th>Nama Barang</th>
		<th>Category Barang</th>
		<th>Stok Barang</th>
		<th>Harga Barang</th>
		<th>Action</th>
	</tr>
	<?php

		$paging   =   isset($_GET['paging']) ? $_GET['paging'] : '';
		$limit    =   2;

		if (empty($paging)) {
			$paging   = 1;
			$position = 0;
		} else {
			$position = ($paging - 1) * $limit;
		}

		$x    =   mysqli_query($dbcon, "SELECT * FROM product INNER JOIN category ON product.category_id=category.id_category ORDER BY id DESC LIMIT $position, $limit");
		$no   =   1;
		foreach ($x as $y) {

	?>
	<tr>
		<td><?=$no++ ?></td>
		<td><?=$y['nama_product'] ?></td>
		<td><?=$y['category_barang'] ?></td>
		<td><?=$y['stok_product'] ?></td>
		<td><?=$y['harga_product'] ?></td>
		<td>
			<?php
				if (isset($_SESSION['username'])) {
					if ($cek_role['role'] == 1) {
			?>
					<a href="?page=edit_product&id=<?=$y['id'] ?>" class="btn btn-sm btn-warning">Edit Product</a>

					<a href="?page=delete_product&id=<?=$y['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete Product</a>
			<?php
					} else {
			?>
					<a href="?page=view_product&id=<?=$y['id'] ?>" class="btn btn-warning btn-sm">Show Product</a>
			<?php
					}
				} else {
			?>
				<a href="?page=view_product&id=<?=$y['id'] ?>" class="btn btn-warning btn-sm">Show Product</a>
			<?php
				}
			?>
		</td>
	</tr>
	<?php } ?>
</table>

<?php

	$jumlah_post    =   mysqli_num_rows(mysqli_query($dbcon, "SELECT * FROM product"));
	$jumlah_halaman =   ceil($jumlah_post/$limit);

	for ($i=1; $i <= $jumlah_halaman ; $i++) { 
		if ($i == $paging) {
?>
	<button class="btn btn-sm"><?=$i ?></button>
<?php
		} else {
?>
	<a href="?paging=<?=$i ?>" class="btn btn-sm"><?=$i ?></a>
<?php
		}
	}
?>
