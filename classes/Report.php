<?php

class Report
{

	const RESULTS_DELIMITER  = ',';

	/**
	 * @var int
	 */
	protected $fieldSize;

	/**
	 * @var array
	 */
	protected $fieldMap;

	/**
	 * @var array
	 */
	protected $results;

	/**
	 * @var array
	 */
	protected $tries;

	/**
	 * @var Log
	 */
	protected $log;

	public function __construct($size, Log $log)
	{
		$this->fieldSize  = $size  ;
		$this->tries      = 0      ;
		$this->fieldMap   = []     ;
		$this->results    = []     ;
		$this->log        = $log   ;
	}

	public function generate()
	{
		$this->log->info('Input data: '.$this->fieldSize.'x'.$this->fieldSize.', '.$this->fieldSize.' items');
		$this->placeItem(0);
	}


	public function getLastResult()
	{
		if(count($this->results))
		{
			return $this->results[count($this->results)-1];
		}
	}


	public function getAllResults()
	{
		return join("\n", $this->results)."\n";
	}


	protected function placeItem($a)
	{
		if($a == $this->fieldSize)
		{
			$this->saveResults();
			return;
		}

		for($i = 0; $i < $this->fieldSize; ++$i)
		{
			if($this->tryItem($a, $i))
			{
				$this->fieldMap[$a][$i] = 1;
				$this->placeItem($a+1);
				$this->fieldMap[$a][$i] = 0;
			}
		}
		return;
	}

	protected function tryItem($a, $b)
	{
		for($i = 0; $i < $a; ++$i)
		{
			if(!empty($this->fieldMap[$i][$b]))
			{
				return false;
			}
		}

		for($i = 1; $i <= $a && $b-$i >= 0; ++$i)
		{
			if(!empty($this->fieldMap[$a-$i][$b-$i]))
			{
				return false;
			}
		}

		for($i = 1; $i <= $a && $b+$i < $this->fieldSize; $i++)
		{
			if(!empty($this->fieldMap[$a-$i][$b+$i]))
			{
				return false;
			}
		}

		return true;
	}

	protected function saveResults()
	{
		$this->results[] = join(self::RESULTS_DELIMITER, array_map(function($row){
			foreach( $row as  $col=>$checked )
			{
				if( $checked )
				{
					return $col+1;
				}
			}
		}, $this->fieldMap));
		$this->log->notice('#'.++$this->tries . ' ( '.$this->getLastResult().' )');
	}

}
