<?php
class AutoloadException extends Exception {
    public function __toString() {
        return get_class($this) . " - Code {$this->code} >> '{$this->message}' in {$this->file}({$this->line})\n"
                                . "{$this->getTraceAsString()}\n";
    }
}

function autoload($class) {

    if (strpos($class, 'Facebook\\') !== false) {
        require_once ROOT_PATH.'core/API/'.$class.'.php';
        return false;
    }

	if (strpos($class, 'Smarty') !== false) {
		require_once ROOT_PATH.'core/Smarty/Smarty.class.php';
		return true;
	}

    $class_folder = $class;
    if (strpos($class, '_') !== false) {
        $class_folder = strtok($class, '_');
        $class = strtok('_');
    }

    $class_name = $class.'.class.php';

    $root_class_folders = array(
        CORE_PATH.$class_folder.'/',
        CONTROLLERS_PATH,
        MODELS_PATH.$class_folder.'/'
    );

    foreach($root_class_folders as $class_path) {
        if (file_exists($class_path.$class_name)) {
            include $class_path.$class_name;
            return true;
        }
    }

    throw new AutoloadException('Undefined class '.$class.' from paths '.implode(' ; ', $root_class_folders));
}

spl_autoload_register('autoload', true, true);