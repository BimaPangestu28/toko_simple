<?php require_once 'database.php'; session_start(); ?>

<!DOCTYPE html>
<html>
	<head>
		<title>Simple Toko Online</title>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="css/style.css">
	</head>
	<body>

		<div class="container"><br>
			
			<?php

				if (isset($_GET['page'])) {
					$page   =  $_GET['page'];

					if (file_exists('page/' . $page . '.php')) {
						include 'page/' . $page . '.php';
					} else {
						echo "Error 404 Not Found";
					}
				} else {
					include 'page/index.php';
				}

			?>

		</div>

	</body>
</html>