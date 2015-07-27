<?php
interface IException {
    public function getClass();
	public function getMessage();
    public function getCode();
    public function getFile();
    public function getLine();
    public function getTrace();
    public function getTraceAsString();

    public function __toString();
    public function __construct($message = null, $code = 0);
}

abstract class CustomException extends Exception implements IException {

    protected $message = 'Unknown exception';
    private   $string;
    protected $code = 0;
    protected $file;
    protected $line;
    private   $trace;

    public function __construct($message = null, $code = 0) {
        parent::__construct($message, $code);
    }

    public function __toString() {
        return $this->getClass() . " - Code {$this->code} >> '{$this->message}' in {$this->file}({$this->line})\n"
                                . "{$this->getTraceAsString()}\n";
    }

	public function getClass() {
		return get_class($this);
	}
}

