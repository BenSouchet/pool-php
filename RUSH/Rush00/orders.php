<?php
session_start();

include 'functions.php';

if ($_SESSION["username"] == NULL || $_SESSION["level"] == "basic" || $_SESSION["level"] == "guest")
	die(header('location:index.php'));
?>
<!DOCTYPE html>
<html>
	<head>
		<title>E-Commerce - Administration</title>
		<meta name="Author" content="bsouchet, behamon" />
		<meta name="Description" content="Rush 00 de la piscine PHP @ 42" />
		<meta name="Language" content="fr" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="google" content="notranslate" />
		<link rel="stylesheet" type="text/css" href="./css/style.css">
		<link rel="stylesheet" type="text/css" href="./css/admin.css">
		<link rel="stylesheet" type="text/css" href="./css/orders.css">
		<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
		<style>
			#main-panel { width: 1168px; }
		</style>
	</head>
	<body>
		<header>
			<div id="top-bar">
				<div id="top-bar-content">
					<?php
						echo '<div id="login-element" style="padding-top: 15px; width: 365px;">';
						echo '<a id="admin" href="./admin.php" title="Administration" >Administration</a><a id="orders" href="./orders.php" title="Orders" style="background-color: #a8a8a8;">Orders</a>';
						echo '<a id="my-account" href="./account.php" title="Account" >My account</a><a id="logout" href="./logout.php" title="Logout">Logout</a>';
						echo '</div>';
					?>
				</div>
			</div>
			<div id="nav-bar">
				<div id="logo">
					<a href="./index.php" alt="Homepage" title="Home">
						<img src="./assets/images/logo.png" />
					</a>
				</div>
				<div id="nav-menu">
					<nav>
						<ul>
							<li style="margin-left: 20px;"><a href="./index.php">Home</a></li>
							<?php
							$catfile = fopen("./private/categories", 'c+');
							if ($catfile)
								$array = explode("\n", fread($catfile, filesize("./private/categories")));
							$array = array_filter($array);
							foreach ($array as $elem)
								if ($elem != "Home")
									echo '<li><a href="./index.php?cat=true&name=' . $elem . '">' . $elem . '</a></li>';
							fclose($catfile);
							?>
						</ul>
					</nav>
				</div>
			</div>
		</header>
		<div id="content">
			<!--<div id="left-panel">
				<h3>My informations</h3>
			</div>-->
			<div id="main-panel">
				<h2>Orders</h2>
				<?php
				$orders_file = fopen("./private/orders.csv", "a+");
				while (($order = fgetcsv($orders_file)) != FALSE)
				{
					echo '<div class="order-block">';
					echo '<h4>Order n° ' .  $order[0] . '</h4>';
					echo '<p class="order-user">Ordered by : ' . $order[1] . '</p>';
					$total_price = 0;
					foreach (unserialize($order[2]) as $article => $qty)
					{
						$article = str_replace("_", " ", $article);
						$price = get_price($article, $qty);
						$total_price += $price;
						echo '<div class="order-product"><p class="order-product-name">' . $article . '</p><div class="order-right-part"><p class="order-elem" style="margin-right:10px;">' . $qty . '&nbsp;&nbsp;&nbsp;-- </p><p class="order-elem">' . $price . '€</p></div></div><br />';
					}
					echo '<p class="order-total">Total: ' . $total_price . '€</p>';
					echo '<br />';
					echo '</div>';
				}
				fclose($orders_file);
				?>
			</div>
		</div>
		<footer>
			<p>© Copyright bsouchet, behamon 2017 - Piscine PHP @ 42 (Paris)</p>
		</footer>
	</body>
</html>
