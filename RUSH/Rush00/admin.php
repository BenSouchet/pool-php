<?php
session_start();

include 'functions.php';

if ($_SESSION["username"] == NULL || $_SESSION["level"] == "basic" || $_SESSION["level"] == "guest")
	die(header('location:index.php'));

if ($_POST['del_user'] == "Delete this account")
{
	if ($_POST['user_to_delete']  == NULL)
		header("location:admin.php?userDeleteFailed=true&reason=empty");
	$return_val = del_user($_POST['user_to_delete']);
	if ($return_val == 0)
		header("location:admin.php?userDeleteFailed=true&reason=notexist");
	else if ($return_val == 2)
		header("location:admin.php?userDeleteFailed=true&reason=rights");
}
else if ($_POST['add_article'] == "Add this article")
{
	if ($_POST['id'] == NULL || $_POST['category'] == NULL || $_POST['price'] == NULL || $_POST['url'] == NULL)
		die(header("location:admin.php?addArticleFailed=true&reason=empty"));
	if (!article_exists($_POST['id'], $_POST['category']))
		add_article($_POST['id'], $_POST['price'], $_POST['category'], $_POST['url']);
	else
		die(header("location:admin.php?addArticleFailed=true&reason=exist"));
}
else if ($_POST['del_article'] == "Delete this article")
{
	if ($_POST['id'] == NULL || $_POST['category'] == NULL)
		die(header("location:admin.php?delArticleFailed=true&reason=empty"));
	if (article_exists($_POST['id'], $_POST['category']))
		del_article($_POST['id'], $_POST['category']);
	else
		die(header("location:admin.php?delArticleFailed=true&reason=notexist"));
}
else if ($_POST['add_category'] == "Add this category")
{
	if ($_POST['id'] == NULL)
		die(header("location:admin.php?addCategorieFailed=true&reason=empty"));
	if (add_category($_POST['id']) != 0)
		die(header("location:admin.php?addCategorieFailed=true&reason=exist"));
}
else if ($_POST['del_category'] == "Delete this category")
{
	if ($_POST['id'] == NULL)
		die(header("location:admin.php?delCategorieFailed=true&reason=empty"));
	if (del_category($_POST['id']) == 0)
		die(header("location:admin.php?delCategorieFailed=true&reason=notexist"));
}
else if ($_POST['edit_user_pw'] == "Edit the password")
{
	if ($_POST['username'] == NULL || $_POST['new_pw'] == NULL || $_SESSION["level"] == NULL)
		die(header("location:admin.php?editPasswordFailed=true&reason=empty"));
	$return_v = modify_password($_POST['username'], $_POST['new_pw'], $_SESSION["level"]);
	if ($return_v == 0)
		die(header("location:account.php?editPasswordFailed=true&reason=notfound"));
	else if ($return_v == 2)
		die(header("location:admin.php?editPasswordFailed=true&reason=rights"));
}


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
		<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
		<style>
			#container, #container1, #container2, #container3, #container3 {margin-top: 25px; width: 100%;}
			#container form {width: 565px!important; margin: 0 auto!important; display: block; }
			#container1 form {width: 590px!important; margin: 0 auto 30px!important; display: block; }
			#container2 form {width: 598px!important; margin: 0 auto 35px!important; display: block; }
			#container3 form {width: 620px!important; margin: 0 auto 35px!important; display: block; }
			#container4 form {width: 620px!important; margin: 0 auto 30px!important; display: block; }
			#container5 form {width: 590px!important; margin: 0 auto 30px!important; display: block; }
			#container { padding-left: 10px; }
			#container2 { margin-left: -10px; }
			#container4 { display: flex; }
			#container5 { height: 185px; margin-left: -20px; }
			#container1 { height: 210px; margin-left: -20px; }
			.elem input { width: 400px!important; }
			#container4 .elem { float: right; }
			#container4 .elem1 { float: right; }
			#container5 .elem { float: right; }
			#container1 .elem { float: right; }
			#container4 {margin-left: -50px;}
			.checkbox-css { width: 20px!important; margin-left: 15px!important; float: left; }
		</style>
	</head>
	<body>
		<header>
			<div id="top-bar">
				<div id="top-bar-content">
					<?php
						echo '<div id="login-element" style="padding-top: 15px; width: 365px;">';
						echo '<a id="admin" href="./admin.php" title="Administration" style="background-color: #a8a8a8;">Administration</a><a id="orders" href="./orders.php" title="Orders">Orders</a>';
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
			<div id="left-panel">
				<h3 style="margin-bottom: 30px;">Active categories :</h3>
				<?php
				$catfile = fopen("./private/categories", 'c+');
				if ($catfile)
					$array = explode("\n", fread($catfile, filesize("./private/categories")));
				$array = array_filter($array);
				foreach ($array as $elem)
					echo '<div class="infos"><p>' . $elem . '</p></div>';
				fclose($catfile);
				?>
				<div class="delimiter2"></div>
				<h3 style="margin-bottom: 30px;">list of users :</h3>
				<?php
				$userfile = fopen("./private/users.csv", "a+");
				if ($userfile != FALSE)
					while (($user = fgetcsv($userfile)) != FALSE)
						echo '<div class="infos"><p>' . $user[0] . '</p></div>';
				fclose($userfile);
				?>
				<div class="delimiter2"></div>
			</div>
			<div id="main-panel">
				<h2>Administration</h2>
				<div class="delimiter"></div>
				<h4>Add an article</h4>
				<?php
					$reasons = array("exist" => "Article already exist!");
					if ($_GET["addArticleFailed"])
					{
						echo '<div id="login-failed"><center><p>';
						echo $reasons[$_GET["reason"]];
						echo '</p></center></div>';
					}
				?>
				<div id="container4">
					<form action="admin.php" method="post">
						<span class="elem"><label for="name">Article name:</label>
						<input type="name" name="id" /><br /></span>
						<span class="elem"><label for="name">Price:</label>
						<input type="name" name="price" /><br /></span>
						<span class="elem1" style="width: 558px;"><label for="name" style="float: left; margin-top: 7px;">Categories:</label>
						<div style="margin-left: 89px; margin-bottom: 15px">
						<!--<input type="name" name="category" /><br /></span>-->
						<?php
						if (file_exists("./private/categories") == TRUE)
						{
							$array = explode("\n", file_get_contents("./private/categories"));
							$array = array_filter($array);
							foreach ($array as $elem)
							{
								echo '<input type="checkbox" class="checkbox-css" name="category[]" value='.$elem.' /><br />';
								echo '<p class="categories-checkbox">'.$elem.'</p>';
							}
						}
						?></div></span>
						<span class="elem"><label for="name">URL Image:</label>
						<input type="name" name="url" /><br /></span>
						<input type="submit" name="add_article" value="Add this article" />
					</form>
				</div>
				<h4>Delete an article</h4>
				<?php
					$reasons = array("notexist" => "Article doesn't exist!", "empty" => "One or more fields was left empty.");
					if ($_GET["delArticleFailed"])
					{
						echo '<div id="login-failed"><center><p>';
						echo $reasons[$_GET["reason"]];
						echo '</p></center></div>';
					}
				?>
				<div id="container1">
					<form action="admin.php" method="post">
						<span class="elem"><label for="name">Article name:</label>
						<input type="name" name="id" /><br /></span>
						<span class="elem"><label for="name">Article category:</label>
						<input type="name" name="category" /><br /></span>
						<input type="submit" name="del_article" value="Delete this article" />
					</form>
				</div>
				<div class="delimiter"></div>
				<h4>Add a category</h4>
				<?php
					$reasons = array("exist" => "Category already exist!", "empty" => "One or more fields was left empty.");
					if ($_GET["addCategorieFailed"])
					{
						echo '<div id="login-failed"><center><p>';
						echo $reasons[$_GET["reason"]];
						echo '</p></center></div>';
					}
				?>
				<div id="container2">
					<form action="admin.php" method="post">
						<label for="name">Category name:</label>
						<input type="name" name="id" />
						<input type="submit" name="add_category" value="Add this category" />
					</form>
				</div>
				<h4>Delete a category</h4>
				<?php
					$reasons = array("notexist" => "Category doesn't exist!", "empty" => "One or more fields was left empty.");
					if ($_GET["delCategorieFailed"])
					{
						echo '<div id="login-failed"><center><p>';
						echo $reasons[$_GET["reason"]];
						echo '</p></center></div>';
					}
				?>
				<div id="container3">
					<form action="admin.php" method="post">
						<label for="name">Category name:</label>
						<input type="name" name="id" />
						<input type="submit" name="del_category" value="Delete this category" />
					</form>
				</div>
				<div class="delimiter"></div>
				<h4>Delete An Account</h4>
				<?php
					$reasons = array("notexist" => "This User doesn't exist.",
									"rights" => "You don't have the rights to do that!",
									"empty" => "One or more fields was left empty.");
					if ($_GET["userDeleteFailed"])
					{
						echo '<div id="login-failed"><center><p>';
						echo $reasons[$_GET["reason"]];
						echo '</p></center></div>';
					}
				?>
				<div id="container">
					<form action="admin.php" method="post">
						<label for="name">Username:</label>
						<input type="name" name="user_to_delete" />
						<input type="submit" name="del_user" value="Delete this account" />
					</form>
				</div>
				<h4 style="margin-top: 35px;">Change password of an Account</h4>
				<?php
					$reasons = array("notexist" => "This User doesn't exist.",
									"rights" => "You don't have the rights to do that!",
									"empty" => "One or more fields was left empty.");
					if ($_GET["editPasswordFailed"])
					{
						echo '<div id="login-failed"><center><p>';
						echo $reasons[$_GET["reason"]];
						echo '</p></center></div>';
					}
				?>
				<div id="container5">
					<form action="admin.php" method="post">
						<span class="elem"><label for="name">Username:</label>
						<input type="name" name="username" /><br /></span>
						<span class="elem"><label for="name">New Password:</label>
						<input type="password" name="new_pw" /><br /></span>
						<input type="submit" name="edit_user_pw" value="Edit the password" />
					</form>
				</div><br /><br />
			</div>
		</div>
		<footer>
			<p>© Copyright bsouchet, behamon 2017 - Piscine PHP @ 42 (Paris)</p>
		</footer>
	</body>
</html>
