<?php

// Users

function user_exists($username)
{
	$userfile = fopen("./private/users.csv", "a+");
	if ($userfile != FALSE)
	{
		while (($user = fgetcsv($userfile)) != FALSE)
			if ($user[0] == $username)
				return TRUE;
		return FALSE;
	}
	fclose($userfile);
}

function create_user($username, $passwd, $level)
{
	$userfile = fopen("./private/users.csv", "a+");
	if ($userfile != FALSE)
	{
		$user = array($username, hash("whirlpool", $passwd), $level);
		fputcsv($userfile, $user);
	}
	fclose($userfile);
}

function del_own_account()
{
	$userfile = fopen("./private/users.csv", "a+");
	$tempfile = fopen('./private/temp.csv', "a+");
	if ($userfile != FALSE)
	{
		while (($user = fgetcsv($userfile)) != FALSE)
		{
			if ($user[0] != $_SESSION["username"])
			{
				$list = $user;
				fputcsv($tempfile, $list);
			}
		}
	}
	fclose($tempfile);
	fclose($userfile);
	rename('./private/temp.csv','./private/users.csv');
}

function del_user($username)
{
	$return_v = 0;
	$userfile = fopen("./private/users.csv", "a+");
	$tempfile = fopen('./private/temp.csv', "a+");
	if ($userfile != FALSE)
	{
		while (($user = fgetcsv($userfile)) != FALSE)
		{
			if ($user[0] != $username)
			{
				$list = $user;
				fputcsv($tempfile, $list);
			}
			else
			{
				if ($user[2] == $_SESSION["level"] || ($_SESSION["level"] == "admin" && $user[2] == "root"))
					return (2);
				$return_v = 1;
			}
		}
	}
	fclose($tempfile);
	fclose($userfile);
	rename('./private/temp.csv','./private/users.csv');
	return ($return_v);
}

// Passwords

function modify_password_admins($username, $newpw, $admin_lvl)
{
	$userfile = fopen("./private/users.csv", "a+");
	if ($userfile != FALSE)
	{
		while (($user = fgetcsv($userfile)) != FALSE)
		{
			if ($user[0] == $username)
			{
				if ($admin_lvl == "admin")
				{
					if ($user[2] == "admin" || $user[2] == "root")
						return (2);
				}
				else if ($admin_lvl == "root")
				{
					if ($user[2] == "root")
						return (2);
				}
				$tmp_level = $user[2];
				delete_user($username);
				create_user($username, $newpw, $tmp_level);
				fclose($userfile);
				return (1);
			}
		}
	}
	fclose($userfile);
	return (0);
}

function modify_password($username, $oldpw, $newpw)
{
	$userfile = fopen("./private/users.csv", "a+");
	if ($userfile != FALSE)
	{
		while (($user = fgetcsv($userfile)) != FALSE)
		{
			if ($user[0] == $username)
			{
				if ($user[1] != hash("whirlpool", $oldpw))
					return (1);
				$tmp_level = $user[2];
				del_own_account();
				create_user($username, $newpw, $tmp_level);
				fclose($userfile);
				return (0);
			}
		}
	}
	fclose($userfile);
}

// Articles

function add_article($id, $price, $cat, $url)
{
	$exist = 0;
	$datafile = fopen("./private/database.csv", "a+");
	if (file_exists("./private/categories") == TRUE)
	{
		$array = explode("\n", file_get_contents("./private/categories"));
		foreach ($array as $elem)
		{
			foreach($cat as $boxes)
			{
				if ($elem == $boxes)
					$exist += 1;
			}
		}
	}
	else
		file_put_contents("./private/categories", "");
	$ncat = implode("\n", $cat)."\n";
	if ($exist == 0)
		file_put_contents("./private/categories", $ncat, FILE_APPEND);
	if ($datafile != FALSE)
		fputcsv($datafile, array($id, $price, serialize($cat), $url));
	fclose($datafile);
}

function article_exists($id, $cat)
{
	$datafile = fopen("./private/database.csv", "a+");
	if ($datafile != FALSE)
	{
		while (($data = fgetcsv($datafile)) != FALSE)
			if ($data[0] == $id && $data[2] == $cat)
				return TRUE;
		return FALSE;
	}
	fclose($datafile);
}

function del_article($id, $cat)
{
	$datafile = fopen("./private/database.csv", "a+");
	$tempfile = fopen('./private/temp.csv', "a+");
	if ($datafile != FALSE)
	{
		while (($article = fgetcsv($datafile)) != FALSE)
		{
			if ($article[0] != $id/* && $article[2] != $cat    ?? */)
 			{
				$list = $article;
				fputcsv($tempfile, $list);
			}
		}
	}
	fclose($tempfile);
	fclose($datafile);
	rename('./private/temp.csv','./private/database.csv');
}

// Categories

function add_category($cat)
{
	$exist = 0;
	if (file_exists("./private/categories") == TRUE)
	{
		$array = explode("\n", file_get_contents("./private/categories"));
		foreach ($array as $elem)
		{
			if ($elem == $cat)
				$exist += 1;
		}
	}
	else
		file_put_contents("./private/categories", "");
	$ncat = $cat. PHP_EOL;
	if ($exist == 0)
		file_put_contents("./private/categories", $ncat, FILE_APPEND);
	return ($exist);
}

function del_category($id)
{
	$i = -1;
	$fexist = 0;
	$catfile = fopen("./private/categories", "a+");
	if ($catfile)
		$array = explode("\n", fread($catfile, filesize("./private/categories")));
	$res = array();
	while ($array[++$i])
	{
		if ($array[$i] != $id)
			array_push($res, $array[$i]);
		else
			$fexist += 1;
	}
	$string = implode("\n", $res);
	ftruncate($catfile, 0);
	file_put_contents("./private/categories", $string."\n");
	fclose($catfile);
	return ($fexist);
}

// Basket

function add_article_to_basket($id)
{
	if (!$_SESSION['basket'][$id])
		$_SESSION['basket'][$id] = 1;
	else
		$_SESSION['basket'][$id] += 1;
}

function is_in_basket($article)
{
	$article = str_replace(" ", "_", $article);
	foreach ($_SESSION['basket'] as $arti => $qty)
	{
		if ($article == $arti)
			return ($qty);
	}
	return (0);
}

function del_article_from_basket($id)
{
	$id = str_replace(" ", "_", $id);
	if ($_SESSION['basket'][$id])
		$_SESSION['basket'][$id] -= 1;
}

function del_article_all_from_basket($id)
{
	$id = str_replace(" ", "_", $id);
	if ($_SESSION['basket'][$id])
		$_SESSION['basket'][$id] = 0;
}

function basket_to_orders($username)
{
	$orders_file = fopen("./private/orders.csv", "a+");
	fputcsv($orders_file, array(rand(10000, 99999), $username, serialize($_SESSION['basket'])));
	fclose($orders_file);
	if ($_SESSION['basket'] != NULL)
		$_SESSION['basket'] = NULL;
}

function get_price($article, $qty)
{
	$datafile = fopen("./private/database.csv", "r");
	while (($line = fgetcsv($datafile)) != FALSE)
	{
		if ($article == $line[0])
			return ($qty * $line[1]);
	}
	fclose($datafile);
	return (0);
}

?>
