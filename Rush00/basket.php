<?php
session_start();

include ('functions.php');

if ($_SESSION["username"] != NULL && ($_SESSION["level"] == "admin" || $_SESSION["level"] == "root"))
	die(header('location:index.php'));

if ($_POST['checkout'] == "Checkout This Basket" && $_SESSION['level'] == "basic")
	basket_to_orders($_SESSION['username']);
	
if ($_POST['empty-basket'] == "Empty the Basket")
{
	if ($_SESSION['basket'] != NULL)
		$_SESSION['basket'] = NULL;
}
foreach ($_POST as $article => $add)
{
	if ($_POST[$article] == "Del 1 Item")
		del_article_from_basket($article);
	if ($_POST[$article] == "Del All")
		del_article_all_from_basket($article);
}


?>
<!DOCTYPE html>
<html>
	<head>
		<title>E-Commerce - Basket</title>
		<meta name="Author" content="bsouchet, behamon" />
		<meta name="Description" content="Rush 00 de la piscine PHP @ 42" />
		<meta name="Language" content="fr" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="google" content="notranslate" />
		<link rel="stylesheet" type="text/css" href="./css/style.css">
		<link rel="stylesheet" type="text/css" href="./css/product.css">
		<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
		<style>
			.add-product-b input[type=submit] { width: 90px!important; float : left; }
			.product { height: 267px!important;}
		</style>
	</head>
	<body>
		<header>
			<div id="top-bar">
				<div id="top-bar-content">
					<?php
						if ($_SESSION["level"] == NULL || $_SESSION["level"] == "guest")
						{
							echo '<div id="login-element">';
							echo '<form action="user.php" method="post"><input type="text" name="login" placeholder="Username" /><input type="password" name="pw" placeholder="Password" /><input type="submit" name="submit" value="Log-In"></form><a id="sign-in-button" href="./sign-in.php" title="Sign-In">Sign-In</a>';
							echo '<a id="orders" href="./basket.php" title="Basket" style="margin-left: 12px;">My Basket</a>';
							echo '</div>';
						}
						else if ($_SESSION["level"] == "basic")
						{
							echo '<div id="login-element" style="padding-top: 15px; width: 270px;">';
							echo '<a id="my-account" href="./account.php" title="Account">My account</a><a id="logout" href="./logout.php" title="Logout">Logout</a>';
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
				<h3>Summary :</h3>
			</div>
			<div id="main-panel">
				<h2 style="margin-top:30px;">My Basket</h2>
				<div id="empty-basket-top-right">
					<form action="basket.php" method="post" style="width: 100%; height: 40px;">
						<input type="submit" name="empty-basket" value="Empty the Basket" id="checkout-basket" />
					</form>
				</div>
				<!-- Start -->


            	<?php
				$datafile = fopen("./private/database.csv", "a+");
				if ($datafile != FALSE && $_SESSION['basket'] != NULL)
				{
					while (($article = fgetcsv($datafile)) != FALSE)
					{
                   		$quantity = 0;
						if (($quantity = is_in_basket($article[0])))
	 					{
                        	echo '<div class="product">';
                        	echo '<div class="product-image">';
                        	echo '<img src="' . $article[3] . '" alt="' . $article[0] . '" title="' . $article[0] . '" />';
                        	echo '</div>';
                        	echo '<div class="product-infos2">';
                        	echo '<p class="product-name">' . $article[0] . '</p><p class="product-price">' . $article[1] .' €</p>';
							echo '<p class="product-name" style="margin-top: 5px;">Quantity: ' . $quantity . '</p>';
                        	echo '</div>';
							echo '<form action="basket.php" method="post" class="add-product-b left">';
							echo '<input type="submit" name="'. $article[0] .'" value="Del 1 Item"/><br />';
							echo '</form>';
							echo '<form action="basket.php" method="post" class="add-product-b left">';
							echo '<input type="submit" name="'. $article[0] .'" value="Del All"/><br />';
							echo '</form>';
							echo '</div>';
                    	}
					}
				}
				fclose($datafile);
				?>


				<!-- End -->
				<div id="basket-validation">
				<?php
				/*if ($_SESSION['basket'] != NULL)
				{
					print_r($_SESSION['basket']);
					foreach ($_SESSION['basket'] as $article_name => $quantity)
					{
						echo '<span>'.$article_name .'</span>';
						echo '<span>'.$quantity.'</span><br />';
					}
				}*/
				if ($_SESSION["level"] == "basic")
				{
					echo '<form action="basket.php" method="post" style="width: 100%; height: 40px;">';
					echo '<input type="submit" name="checkout" value="Checkout This Basket" id="checkout-basket" /></form>';
				}
				else
					echo '<a href="#" title="Go Checkout!"><div id="checkout-basket-disable">Log-in or Sign-in to validate your basket</div></a>';
				?>
			</form>
			</div>
		</div>
		<footer>
			<p>© Copyright bsouchet, behamon 2017 - Piscine PHP @ 42 (Paris)</p>
		</footer>
	</body>
</html>
