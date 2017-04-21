#!/usr/bin/php
<?php

function isValidURL($url)
{
	if ( !(strstr($url, "http://")) && !(strstr($url, "https://")))
		$url = "http://" . $url;
	$file_headers = @get_headers($url);
	if(!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found' || !$fp = curl_init($url))
		return FALSE;
	return TRUE;
}

if ($argc > 1)
{
	if (isValidURL($argv[1]) == FALSE && print("error : bad URL\n"))
		exit;
	if ((strstr($argv[1], "http://")))
		$url = substr($argv[1], strlen("http://"));
	else if ((strstr($argv[1], "https://")))
		$url = substr($argv[1], strlen("https://"));
	else
		$url = $argv[1];
	if (file_exists($url) == FALSE)
		mkdir($url);
	$site = curl_init($argv[1]);
	curl_setopt($site, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($site, CURLOPT_HEADER, FALSE);
	$str = curl_exec($site);
	preg_match_all('/<img.*?src=\"(.*?)\"/si', $str, $match);
	foreach ($match[1] as $elem)
	{
		$elem = preg_replace( '/^\/\//', "http://".$url."/", $elem);
		$elem = preg_replace( '/^\//', "http://".$url."/", $elem);
		$imgname =  substr(strrchr($elem,"/" ), 1 );
		$img = curl_init($elem);
		curl_setopt($img, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($img, CURLOPT_HEADER, 0);
		curl_setopt($img, CURLOPT_BINARYTRANSFER,1);
		$end = curl_exec($img);
		$fd = fopen($url."/".$imgname,'wb');
		fwrite($fd, $end);
	}
	curl_close($site);
}
?>
