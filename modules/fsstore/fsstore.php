<?php

require_once('fsstore_engine.php');

/**
 * Basically a database engine that exploits the file system.
 * Extremely simple, non-indexed and not meant for anything complex.
 */
class Module_FSStore extends \assegai\Module
{
    protected $stores;

	public static function instanciate()
	{
		return true;
	}

    public function _init($options)
    {
        foreach($options as $conn_name => $conn_path) {
            $this->stores[$conn_name] = new FSStoreDB($conn_path);
        }
    }

    public function __get($name)
    {
        if(isset($this->stores[$name])) {
            return $this->stores[$name];
        } else {
            throw new Exception("Unknown store `$name'.");
        }
    }
}
