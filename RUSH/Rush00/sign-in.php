<?php
session_start();
if ($_SESSION["username"] != NULL)
	die(header('location:index.php'));
?>
<!DOCTYPE html>
<html>
	<head>
		<title>E-Commerce - Sign In</title>
		<meta name="Author" content="bsouchet, behamon" />
		<meta name="Description" content="Rush 00 de la piscine PHP @ 42" />
		<meta name="Language" content="fr" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="google" content="notranslate" />
		<link rel="stylesheet" type="text/css" href="./css/style.css">
		<link rel="stylesheet" type="text/css" href="./css/sign-in.css">
		<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
	</head>
	<body>
		<header>
			<div id="top-bar">
				<div id="top-bar-content">
					<div id="login-element">
						<form action="user.php" method="post"><input type="text" name="login" placeholder="Username" /><input type="password" name="pw" placeholder="Password" /><input type="submit" name="submit" value="Log-In"></form><a id="sign-in-button" href="./sign-in.php" title="Sign-In">Sign-In</a>
						<a id="orders" href="./basket.php" title="Basket" style="margin-left: 8px;">My Basket</a>
					</div>
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
			</div>-->
			<div id="main-panel">
				<div id="container">
					<?php
					$reasons = array("user"=> "User already exist in database.",
									"notstrong" => "Password not strong enought!",
									"rpasswd" => "Passwords don't match!",
									"blank" => "One or more fields was left empty.",
									"baduser" => "Bad Username!");
					if ($_GET["signInFailed"])
					{
						echo '<div id="login-failed"><center><p>';
						echo $reasons[$_GET["reason"]];
						echo '</p></center></div>';
					}
					?>
					<form action="user.php" method="post">
						<label for="name">Username:</label>
						<input type="name" name="username" />
						<label for="username">Password:</label>
						<input type="password" name="passwd" />
						<label for="username">Repeat password:</label>
						<input type="password" name="rpasswd" />
						<div id="lower">
							<input type="checkbox"><label class="check" for="checkbox" />Keep me logged in</label>
							<input type="submit" name="createuser" value="Create my account" />
						</div>
					</form>
				</div>
			</div>
		</div>
		<footer>
			<p>© Copyright bsouchet, behamon 2017 - Piscine PHP @ 42 (Paris)</p>
		</footer>
	</body>
</html>