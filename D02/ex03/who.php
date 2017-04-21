#!/usr/bin/php
<?php
date_default_timezone_set('Europe/Paris');
$fd = fopen("/var/run/utmpx", "r");

/*
** ----- Explanations -----
**
** Pack / Unpack format characters (http://php.net/manual/en/function.pack.php) :
** a NUL-padded string
** A SPACE-padded string
** i signed integer
** I unsigned integer
**
** Unpack data from binary (https://www.ibm.com/support/knowledgecenter/ssw_aix_61/com.ibm.aix.files/utmp.h.htm) :
** user:		256 bytes
** id:			4   bytes
** tty_name:	32  bytes
** pid:			4   bytes
** status_type:	2   bytes
** timestamp:	4   bytes
** microsecond:	4   bytes
** hostname:	256 bytes
** padding:		64  bytes
** reserved:	2   bytes
**
** Total : 628 bytes
*/

while (($str = fread($fd, 628)))
	$tab[] = unpack("a256user/a4id/a32line/ipid/itype/i2time/a256host", $str);
foreach ($tab as $elem)
	if ($elem['type'] == 7)
		echo $elem['user']." ".$elem['line']."  ".date("M  j H:i", $elem['time1'])."\n";
?>