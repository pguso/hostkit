<?php

namespace Hostkit\ClientBundle\Services\Library;

/**
 * Class to handle file management 
 * @author Patric Gutersohn
 * @package filemanager
 */
class Filemanager {
    
    public $base_dir = "";

	/**
	 *
	 */
	public function __construct() {
        
        $base_dir = '/var/www/';
        $this->base_dir = $base_dir; 
    }

    /**
     * Recursive version of glob
     * @return array containing all pattern-matched files.
     * @param string $sDir      Directory to start with.
     * @param string $sPattern  Pattern to glob for.
     * @param int $nFlags      Flags sent to glob.
     */
    protected function globr($sDir, $sPattern, $nFlags = NULL) {
        $sDir = escapeshellcmd($sDir);
        // Get the list of all matching files currently in the
        // directory.
        $aFiles = glob("$sDir/$sPattern", $nFlags);
        // Then get a list of all directories in this directory, and
        // run ourselves on the resulting array.  This is the
        // recursion step, which will not execute if there are no
        // directories.
        foreach (@glob("$sDir/*", GLOB_ONLYDIR) as $sSubDir) {
            $aSubFiles = $this->globr($sSubDir, $sPattern, $nFlags);
            $aFiles = array_merge($aFiles, $aSubFiles);
        }
        // The array we return contains the files we found, and the
        // files all of our children found.
        return $aFiles;
    }

    /**
     * Method to get the parent directory
     * @param void
     * @return the full path to the parent dir
     */
    protected function parentDir() {
        $parentDir = join(array_slice(preg_split("/", dirname($_SERVER['PHP_SELF'])), 0, -1), "/") . '/';
        return $parentDir;
    }

    /**
     * Method to change the mode of a file or directory
     * @param mixed $file
     * @param int $octal
     * @example $this->changeMode('/var/www/html/test.php',0777);
     * @return true on success
     */
    protected function changeMode($file, $octal) {
        chmod($file, $octal);
        return true;
    }

    /**
     * Method to perform a Recursive chmod
     * @param mixed $path
     * @param int $filemode
     * @return bool TRUE on success
     */
    protected function chmod_R($path, $filemode) {
        if (!is_dir($path))
            return chmod($path, $filemode);

        $dh = opendir($path);
        while ($file = readdir($dh)) {
            if ($file != '.' && $file != '..') {
                $fullpath = $path . '/' . $file;
                if (!is_dir($fullpath)) {
                    if (!chmod($fullpath, $filemode))
                        return FALSE;
                }
                else {
                    if (!$this->chmod_R($fullpath, $filemode))
                        return FALSE;
                }
            }
        }

        closedir($dh);

        if (chmod($path, $filemode))
            return TRUE;
        else
            return FALSE;
    }

    /**
     * Methiod to convert UNIX style permissions (--rxwrxw) to an octal
     * @param mixed $mode
     * @return int $newmode
     */
    protected function chmodnum($mode) {
        $mode = str_pad($mode, 9, '-');
        $trans = array('-' => '0', 'r' => '4', 'w' => '2', 'x' => '1');
        $mode = strtr($mode, $trans);
        $newmode = '';
        $newmode .= $mode[0] + $mode[1] + $mode[2];
        $newmode .= $mode[3] + $mode[4] + $mode[5];
        $newmode .= $mode[6] + $mode[7] + $mode[8];
        return $newmode;
    }

    /**
     * Method to recursively chown files
     * @param mixed $mypath
     * @param int $uid
     * @param int $gid
     * @return void
     */
    protected function recurse_chown_chgrp($mypath, $uid, $gid) {
        $d = opendir($mypath);
        while (($file = readdir($d)) !== false) {
            if ($file != "." && $file != "..") {
                $typepath = $mypath . "/" . $file;
                if (filetype($typepath) == 'dir') {
                    $this->recurse_chown_chgrp($typepath, $uid, $gid);
                }

                chown($typepath, $uid);
                chgrp($typepath, $gid);
            }
        }
    }

    /**
     * Copy a file, or recursively copy a folder and its contents
     * @author      Aidan Lister <aidan@php.net>
     * @author      Paul Scott
     * @version     1.0.1
     * @param       string   $source    Source path
     * @param       string   $dest      Destination path
     * @return      bool     Returns TRUE on success, FALSE on failure
     */
    protected function copyr($source, $dest) {
        // Simple copy for a file
        if (is_file($source)) {
            return copy($source, $dest);
        }
        // Make destination directory
        if (!is_dir($dest)) {
            mkdir($dest);
        }

        // Loop through the folder
        $dir = dir($source);
        while (false !== $entry = $dir->read()) {
            // Skip pointers
            if ($entry == '.' || $entry == '..') {
                continue;
            }
            // Deep copy directories
            if ($dest !== "$source/$entry") {
                $this->copyr("$source/$entry", "$dest/$entry");
            }
        }
        // Clean up
        $dir->close();
        return true;
    }

    /**
     * Method to determine disk free space
     * NOTE: On UNIX like filesystems make sure that the param is given
     * @param string $drive
     * @return int $df
     */
    protected function df($drive = "C:") {
        if (PHP_OS == 'WINNT' || PHP_OS == 'WIN32') {
            $df = disk_free_space($drive);
        } else {
            $df = disk_free_space("/");
        }
        return $df;
    }

	/**
	 * Gets dir and contents
	 *
	 * @param string $p
	 * @param string $f
	 * @param
	 *
	 * @return array
	 */
    protected function searchDir($p = "", $f = "", $allowed_depth = -1) {
        $this->base_dir = trim($this->base_dir); 
        $p = trim($p);
        $f = trim($f);

        if ($this->base_dir== "")
            $this->base_dir= "./";
        if (substr($this->base_dir, -1) != "/")
            $this->base_dir.="/";

        $p = str_replace(array("../", "./"), "", trim($p, "./"));
        $p = $this->base_dir. $p;

        if (!is_dir($p))
            $p = dirname($p);
        if (substr($p, -1) != "/")
            $p.="/";

        if ($allowed_depth > -1) {
            $allowed_depth = count(explode("/", $this->base_dir)) + $allowed_depth - 1;
            $p = implode("/", array_slice(explode("/", $p), 0, $allowed_depth));
            if (substr($p, -1) != "/")
                $p.="/";
        }

        $filter = ($f == "") ? array() : explode(",", strtolower($f));

        $files = @scandir($p);
        if (!$files)
            return array("contents" => array(), "currentPath" => $p);

        for ($i = 0; $i < count($files); $i++) {
            $fName = $files[$i];
            $fPath = $p . $fName;

            $isDir = is_dir($fPath);
            $add = false;
            $fType = "folder";

            if (!$isDir) {
                $ft = strtolower(substr($files[$i], strrpos($files[$i], ".") + 1));
                $fType = $ft;
                if ($f != "") {
                    if (in_array($ft, $filter))
                        $add = true;
                }else {
                    $add = true;
                }
            } else {
                if ($fName == ".")
                    continue;
                $add = true;

                if ($f != "") {
                    if (!in_array($fType, $filter))
                        $add = false;
                }

                if ($fName == "..") {
                    if ($p == $this->base_dir) {
                        $add = false;
                    }else
                        $add = true;

                    $tempar = explode("/", $fPath);
                    array_splice($tempar, -2);
                    $fPath = implode("/", $tempar);
                    if (strlen($fPath) <= strlen($this->base_dir))
                        $fPath = "";
                }
            }

            if ($fPath != "")
                $fPath = substr($fPath, strlen($this->base_dir));
            if ($add)
                $contents[] = array("fPath" => $fPath, "fName" => $fName, "fType" => $fType);
        }

        $p = (strlen($p) <= strlen($this->base_dir)) ? $p = "" : substr($p, strlen($this->base_dir));
        
        return array("contents" => $contents, "currentPath" => $p);
    }

	/**
	 * @return string
	 */
	public function getBaseDir() {
        return $this->base_dir;
    }

}