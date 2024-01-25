<?php

if(isset($DEBUG) && $DEBUG == 1) {
	
} else {

	error_reporting(0); // Set E_ALL for debuging
	
	include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'elFinderConnector.class.php';
	include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'elFinder.class.php';
	include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'elFinderVolumeDriver.class.php';
	include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'elFinderVolumeLocalFileSystem.class.php';
	function access($attr, $path, $data, $volume) {
		return strpos(basename($path), '.') === 0
			? !($attr == 'read' || $attr == 'write')
			:  null;
	}

}

$opts = array(
	// 'debug' => true,
	'roots' => array(
		array(
			'driver'        => 'LocalFileSystem',   // driver for accessing file system (REQUIRED)
			'path'          => '../../../imagens/',         // path to files (REQUIRED)
			'URL'           => 'http://plusempreend.com.br/imobiliaria/imagens/', // URL to files (REQUIRED)
			'accessControl' => 'access'             // disable and hide dot starting files (OPTIONAL)
		)
	)
);

if(isset($DEBUG) && $DEBUG == 1) {
	
} else {
	$connector = new elFinderConnector(new elFinder($opts));
	$connector->run();
}

