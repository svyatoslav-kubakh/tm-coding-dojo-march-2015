<?php

class Log
{
	const LINE_TYPE_ERROR  = 1;
	const LINE_TYPE_INFO   = 2;
	const LINE_TYPE_NOTICE = 3;

	public function info($string)
	{
		return $this->line($string, self::LINE_TYPE_INFO);
	}

	public function error($string)
	{
		return $this->line($string, self::LINE_TYPE_ERROR);
	}

	public function notice($string)
	{
		return $this->line($string, self::LINE_TYPE_NOTICE);
	}


	protected function line($string, $type)
	{
		$time = date('Y-m-d h:i:s');
		$type_marker = $this->getTypeMarker($type);
		return print("[${time}] ${type_marker} ${string}\n");
	}

	protected function getTypeMarker($type)
	{
		return [
			self::LINE_TYPE_ERROR  => 'ERROR:',
			self::LINE_TYPE_INFO   => 'INFO:' ,
			self::LINE_TYPE_NOTICE => '...'   ,
		][$type];
	}

}
