<?php

include 'functions.php';

if (file_exists("private") == FALSE)
	mkdir("private");
if (!file_exists("private/database.csv"))
{
	add_article("Burger + Frites + Boisson", "5.60", array("Home", "Menus"), "http://i.imgur.com/0TyqtoU.png");
	add_article("Americain + Frites", "3.50", array("Home", "Menus"), "http://www.sandwicherie-pains-et-saveurs-dole.fr/userfiles/1149/sandwichs.png");
	add_article("Jambom", "2.50", array("Sandwichs"), "http://www.sandwicherie-pains-et-saveurs-dole.fr/userfiles/1149/sandwichs.png");
	add_article("Rosette", "2.50", array("Sandwichs"), "http://www.sandwicherie-pains-et-saveurs-dole.fr/userfiles/1149/sandwichs.png");
	add_article("Thon", "2.50", array("Sandwichs"), "http://www.sandwicherie-pains-et-saveurs-dole.fr/userfiles/1149/sandwichs.png");
	add_article("Poulet", "3.00", array("Sandwichs"), "http://www.sandwicherie-pains-et-saveurs-dole.fr/userfiles/1149/sandwichs.png");
	add_article("Americain", "3.20", array("Sandwichs"), "http://www.sandwicherie-pains-et-saveurs-dole.fr/userfiles/1149/sandwichs.png");
}
if (!user_exists("root"))
	create_user("root", "root", "root");
if (!user_exists("guest"))
	create_user("guest", "", "guest");
if (!user_exists("root"))
	create_user("admin", "admin", "admin");

?>
