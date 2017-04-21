<?php
session_start();

include 'functions.php';

foreach ($_POST as $article => $add)
{
	if ($_POST[$article] == "Add Item")
		add_article_to_basket($article);
}

?>
<!DOCTYPE html>
<html>
	<head>
		<title>E-Commerce</title>
		<meta name="Author" content="bsouchet, behamon" />
		<meta name="Description" content="Rush 00 de la piscine PHP @ 42" />
		<meta name="Language" content="fr" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="google" content="notranslate" />
		<link rel="stylesheet" type="text/css" href="./css/style.css">
		<link rel="stylesheet" type="text/css" href="./css/product.css">
		<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
	</head>
	<body>
		<header>
			<div id="top-bar">
				<div id="top-bar-content">
					<?php
						if ($_SESSION["username"] != NULL)
						{
							if ($_SESSION["level"] != "basic")
								echo '<div id="login-element" style="padding-top: 15px; width: 365px;">';
							else
								echo '<div id="login-element" style="padding-top: 15px; width: 270px;">';
							if ($_SESSION["level"] != "basic")
								echo '<a id="admin" href="./admin.php" title="Administration">Administration</a><a id="orders" href="./orders.php" title="Orders">Orders</a>';
							echo '<a id="my-account" href="./account.php" title="Account">My account</a><a id="logout" href="./logout.php" title="Logout">Logout</a>';
							if ($_SESSION["level"] == "basic")
								echo '<a id="orders" href="./basket.php" title="Basket" style="margin-left: 12px;">My Basket</a>';
							echo '</div>';
						}
						else
						{
							echo '<div id="login-element">';
							echo '<form action="user.php" method="post"><input type="text" name="login" placeholder="Username" /><input type="password" name="pw" placeholder="Password" /><input type="submit" name="submit" value="Log-In"></form><a id="sign-in-button" href="./sign-in.php" title="Sign-In">Sign-In</a>';
							echo '<a id="orders" href="./basket.php" title="Basket" style="margin-left: 12px;">My Basket</a>';
							echo '</div>';
						}
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
			<div id="left-panel">
				<h3>Fresh Offers</h3>
				<a href="#" title=""><div class="categorie"></div></a>
				<a href="#" title=""><div class="categorie"></div></a>
				<a href="#" title=""><div class="categorie"></div></a>
				<a href="#" title=""><div class="categorie"></div></a>
				<a href="#" title=""><div class="categorie"></div></a>
				<a href="#" title=""><div class="categorie"></div></a>
			</div>
			<div id="main-panel">
			<?php
			$datafile = fopen("./private/database.csv", "a+");
			if ($datafile != FALSE)
			{
				if ($_GET["cat"])
					$cat = $_GET["name"];
				else
					$cat = "Home";
				$done = array();
				while (($article = fgetcsv($datafile)) != FALSE)
				{
					foreach(unserialize($article[2]) as $catcsv)
					{
						if ($catcsv == $cat && !in_array($article[0], $done))
	 					{
							$done[] = $article[0];
	 						echo '<div class="product">';
	 						echo '<div class="product-image">';
	 						echo '<img src="' . $article[3] . '" alt="' . $article[0] . '" title="' . $article[0] . '" />';
	 						echo '</div>';
	 						echo '<div class="product-infos">';
	 						echo '<p class="product-name">' . $article[0] . '</p><p class="product-price">' . $article[1] .' €</p>';
	 						echo '</div>';
							if ($_GET["cat"])
								echo '<form action="index.php?cat=true&name=' . $_GET["name"] .'" method="post" class="add-product-b">';
							else
								echo '<form action="index.php" method="post" class="add-product-b">';
							echo '<input type="submit" name="'. $article[0] .'" value="Add Item"/><br />';
							echo '</form>';
	 						echo '</div>';
						}
					}
				}
			}
			fclose($datafile);
			?>
			</div>
		</div>
		<footer>
			<p>© Copyright bsouchet, behamon 2017 - Piscine PHP @ 42 (Paris)</p>
		</footer>
	</body>
</html>
