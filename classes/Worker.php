<?php

class Worker
{

	/**
	 * @var Request
	 */
	protected $request;

	/**
	 * @var Report
	 */
	protected $report;

	/**
	 * @var Output
	 */
	protected $output;


	/**
	 * @param Request $request
	 * @param string $teamname
	 */
	public function __construct(Request $request, $teamname)
	{
		$this->request = $request;
		$this->log = new Log;
		$this->initOutput( $teamname );
		$this->initReport();
		$this->initShutdownHandler();
		$this->setTimeLmit();
	}

	public function shutdownHandler()
	{
		$a = error_get_last();
		if( ! $a )
		{
//			$this->log->info('No errors');
		}
		else
		{
			$this->log->error($a['message']);
			$this->saveReport();
		}
	}

	public function run()
	{
		$this->report->generate();
		$this->log->info('All items successfully placed');
		$this->saveReport();
	}

	protected function initShutdownHandler()
	{
		register_shutdown_function([$this, 'shutdownHandler']);
	}

	protected function initOutput($teamname)
	{
		$filename = join('-', [
				$teamname,
				$this->request->getSize    (),
				$this->request->getTimeout (),
			]).'.csv';
		$this->output = new Output($filename, $this->log);

	}

	protected function initReport()
	{
		$this->report = new Report(
			$this->request->getSize (),
			$this->log
		);
	}

	protected function saveReport()
	{
		$this->output
			->put( $this->report->getAllResults() );
	}

	protected function setTimeLmit()
	{
		$seconds = (int) ( $this->request->getTimeout() * 60 );
		set_time_limit($seconds);
		ini_set("max_execution_time", $seconds);
		$this->log->info("Max execution time: $seconds seconds");
	}

}
