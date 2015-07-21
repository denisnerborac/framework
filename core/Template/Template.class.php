<?php

class TemplateException extends CustomException {};

class Template extends Smarty
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

		if (!file_exists(self::getPath($this->template))) {
			throw new TemplateException('Template Not Exists >> '.$this->template);
		}
	}

	public function getTpl() {
		return getTemplate();
	}

	public function getTemplate() {
		return $this->template;
	}

	public function setTpl($template) {
		return setTemplate($template);
	}

	public function setTemplate($template) {
		$this->template = $template;
		return true;
	}

	public static function getCleanFile($_tpl = null) {
		if (empty($_tpl)) {
            throw new TemplateException('Empty template');
        }
        if (false === strpos($_tpl, '.tpl')) {
            $_tpl .= '.tpl';
        }
        return $_tpl;
	}
	public static function getPath($_tpl) {
		$_tpl = self::getCleanFile($_tpl);
        return TPL_PATH . $_tpl;
    }

	public function display($template = null, $cache_id = null, $compile_id = null, $parent = null) {
		parent::display($template, $cache_id, $compile_id, $parent);
		return true;
	}
}
