{"files":[<?php
$dir = '../js/config';
$files = scandir($dir);
$files = array_diff($files, array('.', '..'));
$i = 0;

foreach ($files as &$value) {
	echo "\"$value\"";
	$i++;
	if ($i != count($files)) {
		echo ",";
	}
}
?>
]}