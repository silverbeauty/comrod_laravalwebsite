<?php

namespace App\Services;

use ErrorException;

class ErrorLog
{
	public static function set($message)
	{
		$content = '';
		$log = base_path().'/resources/errors.log';
		if (file_exists($log)) {
			$content = file_get_contents($log);
		}
		try {
			$file = fopen($log, 'w+');
		} catch (ErrorException $exception) {
			chmod($log, 777);
			$file = fopen($log, 'w+');
		}
		if ($message != '') {
			$suffix = '';
			if ($content != '') {
				$suffix = "\n\n";
			}
			$content = $content.$suffix.$message;
		}
		fwrite($file, $content);
		fclose($file);
	}
}