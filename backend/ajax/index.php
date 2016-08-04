<?php
	session_start();
    chdir('../../');

	$okay = new Okay();
	$manager = $okay->managers->get_manager();
	if ($manager) {
		$file = $okay->request->get('file', 'string');
		$file = preg_replace("/[^A-Za-z0-9_]+/", "", $file);
		if ($file) {
			require_once($file.'.php');
		}
	}