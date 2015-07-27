<?php
class ViewException extends CustomException {};

class View extends \Smarty
{
	private $template;

	public function __construct($template) {

		parent::__construct();

		$this->setTemplateDir(TPL_PATH);
		$this->setCompileDir(TPL_CACHE_PATH);

		$this->template = self::getCleanFile($template);
		$this->debugging = TPL_DEBUGGING;
		$this->caching = TPL_CACHING;
		$this->force_compile = TPL_FORCE_COMPILE;

		if (!file_exists(self::getAbsolutePath($this->template))) {
			throw new ViewException('View Not Exists >> '.$this->template);
		}
	}

	public function getTemplate() {
		return $this->template;
	}

	public function setTemplate($template) {
		$this->template = $template;
		return true;
	}

	public static function getCleanFile($_tpl = null) {
		if (empty($_tpl)) {
            throw new ViewException('Empty template');
        }
        if (false === strpos($_tpl, '.tpl')) {
            $_tpl .= '.tpl';
        }
        return $_tpl;
	}

	public static function getAbsolutePath($_tpl) {
		$_tpl = self::getCleanFile($_tpl);
        return TPL_PATH . $_tpl;
    }

    // Smarty interfaces
	public function display($template = null, $cache_id = null, $compile_id = null, $parent = null) {
		$result = parent::display($template, $cache_id, $compile_id, $parent);
		// Custom stuff
		return $result;
	}

	public function fetch($template = null, $cache_id = null, $compile_id = null, $parent = null, $display = false, $merge_tpl_vars = true, $no_output_filter = false) {
		$result = parent::fetch($template, $cache_id, $compile_id, $parent, $display, $merge_tpl_vars, $no_output_filter);
		// Custom stuff
		return $result;
	}
}
