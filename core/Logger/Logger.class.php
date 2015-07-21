<?php
class Logger {

	public static function log($msg, $file = 'php_error') {
		self::_error_log($msg, $file);
	}

	private static function _error_log($msg, $file = 'default') {
		$log_file = self::_cleanLogFile($file);
		$log_path = self::_getLogPath();

		error_log($msg.PHP_EOL, 3, $log_path.'/'.$log_file);

		return true;
	}

	private static function _getLogPath() {

		if (is_dir(LOGS_PATH)) {
			return LOGS_PATH;
		}

		$default_path_parts = pathinfo(ini_get('error_log'));
		$default_log_path = $default_path_parts['dirname'];

		return $default_log_path;
	}

	private static function _cleanLogFile($log_file) {
		return (false === strpos($log_file, '.log')) ? $log_file.'.log' : $log_file;
	}
}