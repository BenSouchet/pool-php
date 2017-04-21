#!/usr/bin/php
<?php
$file = file_get_contents($argv[1]);
echo "$file";
preg_match_all('/title.*?=.*?"([^"]+)"/', $file, $titles, PREG_PATTERN_ORDER);
foreach ($titles[1] as $title)
	$file = str_replace($title, strtoupper($title), $file);
preg_match_all('/<a.*?>(.*?)<\/a.*?>/', $file, $link_texts, PREG_PATTERN_ORDER);
foreach ($link_texts[0] as $link_text)
{
	preg_match_all('/>(.*?)</', $link_text, $text, PREG_PATTERN_ORDER);
	$file = str_replace($text[0][0], strtoupper($text[0][0]), $file);
}
echo "$file";
?>
