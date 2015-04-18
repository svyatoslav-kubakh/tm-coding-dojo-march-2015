<?php

class Request
{
	/**
	 * @var int
	 */
	protected $size;

	/**
	 * @var int
	 */
	protected $items;

	/**
	 * @var int
	 */
	protected $timeout;


	/**
	 * @param array $args
	 */
	public function __construct(array $args)
	{
		$this->size    = (int)   $this->safeSet($args, 1, 8); // first  cli argument, 8 items  by default
		$this->timeout = (float) $this->safeSet($args, 2, 1); // second cli argument, 1 minute by default
	}

	/**
	 * @return int
	 */
	public function getSize()
	{
		return $this->size;
	}

	/**
	 * @return int
	 */
	public function getTimeout()
	{
		return $this->timeout;
	}




	/**
	 * @param array $args
	 * @param $index
	 * @param null $default
	 * @return null
	 */
	protected function safeSet(array $args, $index, $default=null)
	{
		return isset($args[$index])
			? $args[$index]
			: $default
			;
	}
}
