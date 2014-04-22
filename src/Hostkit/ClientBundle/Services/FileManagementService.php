<?php

/**
 * FileManagementService.php
 *
 * @category            Hostkit
 * @package             ClientBundle
 * @subpackage          Service
 */

namespace Hostkit\ClientBundle\Services;

use Hostkit\ClientBundle\Services\Library\Common,
    Hostkit\ClientBundle\Services\Library\Filemanager;

/**
 * Class FileManagementService
 * @package Hostkit\ClientBundle\Services
 */
class FileManagementService extends Filemanager {

	/**
	 * @param $container
	 * @param $em
	 */
	public function __construct($container, $em) {
        parent::__construct();
    }

	/**
	 * @param string $p
	 * @param string $f
	 * @param        $allowed_depth
	 *
	 * @return string
	 */public function getFileManager( $p = "", $f = "", $allowed_depth = -1) {
        $fileManager = json_encode($this->searchDir($p, $f, $allowed_depth));
        
        return $fileManager;
    }

	/**
	 * @param $path
	 * @param $filename
	 *
	 * @return string
	 */public function addFile($path, $filename) {
        if(is_writable($this->base_dir . $path . '/')) {
            $handle = fopen($this->base_dir . $path . '/' . $filename, 'w+');
            fwrite($handle, ' ');
            fclose($handle);
            return 'Datei wurden in ' . $path . ' gespeichert.';
        }
        return 'Datei konnte nicht gespeichert werden.';
    }

	/**
	 * @param $path
	 * @param $foldername
	 *
	 * @return string
	 */public function addFolder($path, $foldername) {
        if(is_writable($this->base_dir . $path . '/')) {
            mkdir($this->base_dir . $path . '/' . $foldername, 0755);
            return 'Ordner wurden in ' . $path . ' gespeichert.';
        }
        return 'Datei konnte nicht gespeichert werden.';
    }

}


