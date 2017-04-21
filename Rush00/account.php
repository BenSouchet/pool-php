<?php
session_start();
if ($_SESSION["username"] == NULL || $_SESSION["level"] == "guest")
	die(header('location:index.php'));

include 'functions.php';

if ($_POST['delaccount'] == "Delete My account")
{
	del_own_account();
	if ($_SESSION['username'] != NULL)
		$_SESSION['username'] = NULL;
	if ($_SESSION['level'] != NULL)
		$_SESSION['level'] = NULL;
	die(header('location:index.php'));
}



if ($_POST['editpw'] == "Edit my password")
{
	if ($_POST['oldpw'] == NULL || $_POST['newpw'] == NULL || $_POST['rnewpw'] == NULL)
		die(header("location:account.php?editPasswordFailed=true&reason=blank"));
	else if ($_POST['newpw'] != $_POST['rnewpw'])
		die(header("location:account.php?editPasswordFailed=true&reason=nomatch"));
	else if ($_POST['oldpw'] == $_POST['newpw'])
		die(header("location:account.php?editPasswordFailed=true&reason=nochange"));
	else
	{
		if (modify_password($_SESSION['username'], $_POST['oldpw'], $_POST['newpw']) == 1)
			die(header("location:account.php?editPasswordFailed=true&reason=oldwrong"));
	}
}

?>
<!DOCTYPE html>
<html>
	<head>
		<title>E-Commerce - My account</title>
		<meta name="Author" content="bsouchet, behamon" />
		<meta name="Description" content="Rush 00 de la piscine PHP @ 42" />
		<meta name="Language" content="fr" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="google" content="notranslate" />
		<link rel="stylesheet" type="text/css" href="./css/style.css">
		<link rel="stylesheet" type="text/css" href="./css/admin.css">
		<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
		<style>
			#container, #container1 { width: 440px; margin: 0 auto;}
			#container form { width: 100%; }
			#container .elem { float: right; }
			#container input[type=submit] { width: 226px; }
			#container1 input[type=submit] { width: 400px; margin-top: 20px}
		</style>
	</head>
	<body>
		<header>
			<div id="top-bar">
				<div id="top-bar-content">
					<?php
						if ($_SESSION["level"] != "basic")
							echo '<div id="login-element" style="padding-top: 15px; width: 365px;">';
						else
							echo '<div id="login-element" style="padding-top: 15px; width: 270px;">';
						if ($_SESSION["level"] != "basic")
							echo '<a id="admin" href="./admin.php" title="Administration">Administration</a><a id="orders" href="./orders.php" title="Orders">Orders</a>';
						echo '<a id="my-account" href="./account.php" title="Account" style="background-color: #a8a8a8;" >My account</a><a id="logout" href="./logout.php" title="Logout">Logout</a>';
						if ($_SESSION["level"] == "basic")
							echo '<a id="orders" href="./basket.php" title="Basket" style="margin-left: 12px;">My Basket</a>';
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
			<div id="left-panel">
				<h3 style="margin-bottom: 30px;">My informations :</h3>
				<?php
				echo '<div class="infos"><p>Username : ' . $_SESSION["username"] . '</p></div>';
				if ($_SESSION["level"] == "basic")
					echo '<div class="infos"><p>Account type : User</p></div>';
				else if ($_SESSION["level"] == "admin")
					echo '<div class="infos"><p>Account type : Admin</p></div>';
				else
					echo '<div class="infos"><p>Account type : Root</p></div>';
				?>
				<div class="delimiter2"></div>
			</div>
			<div id="main-panel">
				<h2>My account</h2>
				<h4>Edit my password</h4>
				<?php
					$reasons = array("nomatch" => "Passwords don't match!",
									"oldwrong" => "Old Password wrong!",
									"nochange" => "Old & New Password are identical!",
									"blank" => "One or more fields was left empty.");
					if ($_GET["editPasswordFailed"])
					{
						echo '<div id="login-failed"><center><p>';
						echo $reasons[$_GET["reason"]];
						echo '</p></center></div>';
					}
				?>
				<div id="container">
					<form action="account.php" method="post">
						<span class="elem"><label for="name">Old password:</label>
						<input type="password" name="oldpw" /><br /></span>
						<span class="elem"><label for="name">New password:</label>
						<input type="password" name="newpw" /><br /></span>
						<span class="elem"><label for="name">Repeat new password:</label>
						<input type="password" name="rnewpw" /><br /></span>
						<input type="submit" name="editpw" value="Edit my password" />
					</form>
					<?php
					$reasons = array("notexist"=> "This User doesn't exist.");
					if ($_GET["userDeleteFailed"])
					{
						echo '<div id="user-delete-failed"><p>';
						echo $reasons[$_GET["reason"]];
						echo '</p></div>';
					}
					?>
				</div><br />
				<div class="delimiter2"></div>
				<?php
					if ($_SESSION["level"] != "root")
					{
						echo '<h4>Delete my account</h4>';
						echo '<div id="container1" style="width:410px;">';
						echo '<form action="account.php" method="post">';
						echo '<input type="submit" name="delaccount" value="Delete My account" />';
						echo '</form>';
						echo '</div>';
					}
				?>
			</div>
		</div>
		<footer>
			<p>© Copyright bsouchet, behamon 2017 - Piscine PHP @ 42 (Paris)</p>
		</footer>
	</body>
</html>
