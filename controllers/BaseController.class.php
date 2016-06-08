<?php
abstract class BaseController extends Controller {

	public function __construct() {

		parent::__construct();

		$vars = array(
			'HTTP_ROOT' => ROOT_HTTP.$this->lang->getUserLang().'/',
			'CSS_ROOT' => CSS_HTTP,
			'JS_ROOT' => JS_HTTP,
			'IMG_ROOT' => IMG_HTTP,
			'GLOBAL_AJAX' => GLOBAL_AJAX,
			'referer' => REFERER,
			'uri' => $this->getUri(),
			'querystring' => $this->getQueryString(),
			'current_page' => $this->route,
			'target' => $this->target,
			'action' => $this->action,
			'lang' => $this->lang->getUserLang(),
			'isAjax' => $this->request->isAjax(),
			'website_title' => 'Website Title',
			'website_description' => 'Website Description',
			'author' => 'Website Author',
			'title' => '',
			'description' => ''
		);

		$vars['pages'] = array(
			'home' => Lang::_('Home'),
			'post/archives' => Lang::_('Archives'),
			'search' => Lang::_('Search'),
			'' => array('Map', array(
				'map/geolocation' => Lang::_('Geolocation'),
				'map/geocoding' => Lang::_('Geocoding'),
			)),
			'contact' => Lang::_('Contact'),
		);

		if (User::isLogged()) {
			$vars['user'] = User::get($this->session->user_id);
		}

		$archives_dates = array();
		for($i = 0; $i < 12; $i++) {
			$time = strtotime('-'.$i.' month');
			$month_value = date('Y-m', $time);
			$month_label = ucfirst(Lang::_(strtolower(date('F', $time))));
			$year = date('Y', $time);
			$archives_dates[$month_value] = $month_label.' '.$year;
		}

		$vars['archives_dates'] = $archives_dates;

		$vars['themes'] = glob(CSS_PATH.'themes/*');

		$current_theme = $this->request->get('theme', '');
		if (!empty($current_theme)) {
			$this->session->theme = $current_theme;
		}

		$vars['current_theme'] = $this->session->theme ?: $current_theme;

		$this->response->addVars($vars);
	}

}