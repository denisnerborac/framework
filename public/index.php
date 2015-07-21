<?php
try {

	require_once '../config/core.conf.php';

	//$session = new Session(SESSION_DEFAULT_NAME);

	header('Content-type: text/html; charset='.Lang::$encoding);

	$request = new Request();
	$response = new Response();

	$controller = new ActionController($request, $response);
	$controller->handle();

} catch (Exception $e) {

	if ($e instanceOf AutoloadException || $e instanceOf TemplateException) {
        $response->render('500');
    }

	if ($e instanceOf ActionControllerException) {
		$response->render('404');
	}

	$class_exception = get_class($e);

	Logger::log($class_exception.' : '.$e->getMessage());

	if (CORE_DEBUG) {
		echo '<pre>'.$e.'</pre>';
    }
}
?>