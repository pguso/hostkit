<?php
namespace Hostkit\ClientBundle\Services\Library;

/**
 * Class Common
 * @package Hostkit\ClientBundle\Services\Library
 */
class Common {

	/**
	 *
	 */
	public function __construct() {

        
    }

    public function generateFileManager() {

    }

	/**
	 * @param        $size
	 * @param null   $max
	 * @param string $system
	 * @param string $retstring
	 *
	 * @return string
	 */private function size_readable($size, $max = null, $system = 'si', $retstring = '%01.2f %s') {
        $systems['si']['prefix'] = array('B', 'K', 'MB', 'GB', 'TB', 'PB');
        $systems['si']['size'] = 1000;
        $systems['bi']['prefix'] = array('B', 'KiB', 'MiB', 'GiB', 'TiB', 'PiB');
        $systems['bi']['size'] = 1024;
        $sys = isset($systems[$system]) ? $systems[$system] : $systems['si'];
        $depth = count($sys['prefix']) - 1;
        if ($max && false !== $d = array_search($max, $sys['prefix'])) {
            $depth = $d;
        }
        $i = 0;
        while ($size >= $sys['size'] && $i < $depth) {
            $size /= $sys['size'];
            $i++;
        }
        return sprintf($retstring, $size, $sys['prefix'][$i]);
    }

	/**
	 * @param $mode
	 *
	 * @return string
	 */private function view_perms($mode) {
        $owner["read"] = ($mode & 00400) ? "r" : "-";
        $owner["write"] = ($mode & 00200) ? "w" : "-";
        $owner["execute"] = ($mode & 00100) ? "x" : "-";
        $group["read"] = ($mode & 00040) ? "r" : "-";
        $group["write"] = ($mode & 00020) ? "w" : "-";
        $group["execute"] = ($mode & 00010) ? "x" : "-";
        $world["read"] = ($mode & 00004) ? "r" : "-";
        $world["write"] = ($mode & 00002) ? "w" : "-";
        $world["execute"] = ($mode & 00001) ? "x" : "-";

        if (($mode & 0xC000) === 0xC000) {
            $type = "s";
        } elseif (($mode & 0x4000) === 0x4000) {
            $type = "d";
        } elseif (($mode & 0xA000) === 0xA000) {
            $type = "l";
        } elseif (($mode & 0x8000) === 0x8000) {
            $type = "-";
        } elseif (($mode & 0x6000) === 0x6000) {
            $type = "b";
        } elseif (($mode & 0x2000) === 0x2000) {
            $type = "c";
        } elseif (($mode & 0x1000) === 0x1000) {
            $type = "p";
        } else {
            $type = "?";
        }

        if ($mode & 0x800) {
            $owner["execute"] = ($owner["execute"] == "x") ? "s" : "S";
        }
        if ($mode & 0x400) {
            $group["execute"] = ($group["execute"] == "x") ? "s" : "S";
        }
        if ($mode & 0x200) {
            $world["execute"] = ($world["execute"] == "x") ? "t" : "T";
        }

        $ret = $type . join("", $owner) . join("", $group) . join("", $world);
        return $ret;
    }

	/**
	 * @param $o
	 *
	 * @return string
	 */private function view_perms_color($o) {
        if (!is_readable($o)) {
            $ret = '<span class="no">' . view_perms(@fileperms($o)) . '</span>';
        } elseif (!is_writable($o)) {
            $ret = '<span>' . view_perms(@fileperms($o)) . '</span>';
        } else {
            $ret = '<span class="ok">' . view_perms(@fileperms($o)) . '</span>';
        }
        return $ret;
    }

	/**
	 * @param $file
	 *
	 * @return bool|int
	 */private function is_binary($file) {
        if (@file_exists($file)) {
            if (!@is_file($file))
                return 0;

            $fh = @fopen($file, "r");
            $blk = @fread($fh, 512);
            @fclose($fh);
            clearstatcache();

            return (
                    0 or @substr_count($blk, "^ -~", "^\r\n") / 512 > 0.3
                    or @substr_count($blk, "\x00") > 0
                    );
        }
        return 0;
    }

	/**
	 * @param      $directory
	 * @param bool $empty
	 *
	 * @return bool
	 */private function deleteAll($directory, $empty = false) {
        if (substr($directory, -1) == "/") {
            $directory = substr($directory, 0, -1);
        }

        if (!file_exists($directory) || !is_dir($directory)) {
            return false;
        } elseif (!is_readable($directory)) {
            return false;
        } else {
            $directoryHandle = opendir($directory);

            while ($contents = readdir($directoryHandle)) {
                if ($contents != '.' && $contents != '..') {
                    $path = $directory . "/" . $contents;

                    if (is_dir($path)) {
                        deleteAll($path);
                    } else {
                        unlink($path);
                    }
                }
            }

            closedir($directoryHandle);

            if ($empty == false) {
                if (!rmdir($directory)) {
                    return false;
                }
            }

            return true;
        }
    }

	/**
	 * @param $string
	 *
	 * @return mixed
	 */private function unslash($string) {
        while (strpos($string, '//') !== false) {
            $string = str_replace('//', '/', $string);
        }
        return $string;
    }

}

