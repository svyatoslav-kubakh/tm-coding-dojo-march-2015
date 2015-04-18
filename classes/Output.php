<?php

class Output
{

	/**
	 * @var string
	 */
	protected $filename;

	/**
	 * @var Log
	 */
	protected $log;

	public function __construct($filename, Log $log)
	{
		$this->filename = $filename;
		$this->log = $log;
	}

	public function put($data)
	{
		if( file_put_contents($this->filename, $data) !== false )
		{
			$this->log->notice('last results in "' . $this->filename . '"');
		}
		else
		{
			$this->log->error('File write error, "' . $this->filename . '"');
		}
	}

}
