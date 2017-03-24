<?php

	if (isset($_GET['id'])) {
		$id    =   $_GET['id'];

		$x    =   mysqli_fetch_array(mysqli_query($dbcon, "SELECT * FROM product WHERE id=$id"));

		if (unlink('images/' . $x['gambar_product'])) {
			mysqli_query($dbcon, "DELETE FROM product WHERE id=$id");

			header("location:index.php");
		}
	}

?>