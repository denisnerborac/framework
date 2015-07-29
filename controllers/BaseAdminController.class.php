<?php
abstract class BaseAdminController extends BaseController {

	public function __construct() {

		parent::__construct();

		$vars['website_title'] = 'Backoffice';
		$vars['website_description'] = 'Admin Description';
		$vars['author'] = 'Admin Author';

		$vars['pages'] = array(
			'admin/index/' => array('Dashboard', 'fa-dashboard'),
            'admin/post/' => array('Posts', 'fa-file-text'),
            'admin/contact/' => array('Contacts', 'fa-envelope')
		);

		$this->response->addVars($vars);
	}

	protected function base_list($entity_name, $cols, $order = 'id') {

		if (empty($cols)) {
			throw new Exception('Base list error - Undefined columns for table');
		}

		$class = ucfirst($entity_name);

		if (!class_exists($class)) {
			throw new Exception('Base list error - Undefined class '.$class);
		}

		$list = $class::getList('SELECT * FROM '.$entity_name.' ORDER BY '.$order);

		$table = new Table('data-table', $entity_name, $list, $cols, ROOT_HTTP.'admin/'.$entity_name.'/update', ROOT_HTTP.'admin/'.$entity_name.'/delete');

		$vars = array(
			'list' => $list,
			'table' => $table->render()
		);

		$this->render('admin/'.$entity_name, $vars);
	}

	protected function base_action($entity_name) {

		$class = ucfirst($entity_name);

		if (!class_exists($class)) {
			throw new Exception('Base action error - Undefined class '.$class);
		}

		// action => id required ? true/false
		$actions = array('create' => false, 'update' => true, 'delete' => true);

		$action = $this->getParam(0, '');
		$id = (int) $this->getParam(1, 0);

		if (!isset($actions[$action])) {
			throw new Exception($class.' action error - Undefined action '.$action);
		}
		if ($actions[$action] === true && empty($id)) {
			throw new Exception($class.' action error - Undefined id for action '.$action);
		}

		$form_action = ROOT_HTTP.'admin/'.$entity_name.'/'.$action.'/'.($id ?:'');

		$isPost = $action == 'delete' ? true : $this->request->isPost();
		$errors = array();
		$success = false;

		$entity = new $class();
		if (!empty($id)) {
			$entity = $class::get($id);
			if (empty($entity)) {
				throw new Exception('Undefined '.$entity_name.' with id = ['.$id.']');
			}
		}

		if ($isPost) {

			if ($action != 'delete') {
				foreach($entity->getFields() as $key => $value) {
					try {
						if ($key != 'id') {
							$entity->$key = $this->request->post($key, '');
						}
					} catch (Exception $e) {
						$errors[$key] = $e->getMessage();
					}
				}
			}

			if (empty($errors)) {
				switch ($action) {
					case 'create':
						$success = $entity->insert();
					break;
					case 'update':
						$success = $entity->update();
					break;
					case 'delete':
						$success = $entity->delete();
					break;
				}
			}
		}

		$form = $entity->getForm($action, $form_action, $this->request, $isPost, $errors);

		$vars['action'] = $action;
		$vars['form'] = $form;
		$vars['isPost'] = $isPost;
		$vars['success'] = $success;
		$vars['errors'] = $errors;

		$this->render('admin/'.$entity_name, $vars);
	}
}