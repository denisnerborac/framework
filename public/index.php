<?php
try {

	require_once '../config/core.conf.php';

	header('Content-type: text/html; charset='.Lang::$encoding);

	//$profiler = new Profiler();

	$controller = new ActionController();
	$controller->handle();

	//$profiler->stop();
	//echo $profiler->getSummary();

} catch (Exception $e) {

	$response = new Response();

	if ($e instanceOf AutoloadException || $e instanceOf ViewException) {
        $response->render('500');
    }

	if ($e instanceOf ActionControllerException) {
		$response->render('404');
	}

	$class_exception = get_class($e);
	$msg_exception = $class_exception.' : '.$e->getMessage();

	Logger::log($msg_exception);

	if (CORE_DEBUG) {
		echo '<pre>'.$msg_exception.'</pre>';
    }
}