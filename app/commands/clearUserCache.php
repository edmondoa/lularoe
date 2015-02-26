<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class clearUserCache extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'cp:clearusercache';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Command to clear all cached data for the user table.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		foreach(User::all() as $user)
		{
			$user->clearUserCache();
			Log::info('Cache cleared for user:'.$user->first_name." ".$user->last_name);
		}

	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			//array('example', InputArgument::REQUIRED, 'An example argument.'),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
		);
	}

}
