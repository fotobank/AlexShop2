<?php

require_once __DIR__ . '/../../system/configs/define/config.php';
require_once SYS_DIR . 'core' . DS . 'boot.php';

    chdir('../../');



	$registry = new Registry();
	$manager = $registry->managers->get_manager();
	if ($manager) {
		$file = $registry->request->get('file', 'string');
		$file = preg_replace("/[^A-Za-z0-9_]+/", "", $file);
		if ($file) {
			require_once($file.'.php');
		}
	}