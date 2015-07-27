<?php
class ActionControllerException extends CustomException {}

class ActionController extends Controller {

    public function handle() {

        $class = ucfirst($this->target).'Controller';
		$method = strtolower($this->action);

        if (!class_exists($class)) {
			throw new ActionControllerException('Undefined class '.$class.' from target '.$this->target);
        }

        $controller = new $class();

		if (!method_exists($class, $method)) {
			throw new ActionControllerException('Undefined action '.$this->action.' in class '.$class);
		}

		return $controller->$method();
    }

    public static function processException(Request $request, Response $response, Exception $e) {
        $controller = new self($request, $response);
        return $controller->launchException($e);
    }

    private function actionExists($action) {
        try {
            $method = new ReflectionMethod(get_class($this),$action);
            return method_exists($this, $action) && $method->isPublic() && !$method->isConstructor();
        } catch (Exception $e) {
            return false;
        }
    }
}
