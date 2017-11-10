<?php

namespace App\Console\Commands;

use function config;
use Illuminate\Console\Command;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use PDOException;

class ClearDB extends Command
{
	/**
	 * The name and signature of the console command.
	 * @var string
	 */
	protected $signature = 'migrate:cleardb';

	/**
	 * The console command description.
	 * @var string
	 */
	protected $description = 'drop the database tables without constraints checking';


	/**
	 * Create a new command instance.
	 */
	public function __construct ()
	{
		parent::__construct();
	}


	/**
	 * Execute the console command.
	 * @return mixed
	 */
	public function handle ()
	{
		$dbName = config('database.connections.mysql.database');
		$drop = "DROP DATABASE IF EXISTS $dbName;";
		$create = "CREATE DATABASE $dbName;";

		try{
			DB::statement($drop);
			DB::statement($create);
			print "Database '$dbName' cleared.\n";
		}catch(QueryException $e)
		{
			print "Failed to clear the database...\n";
			print $e->getMessage();
			print "\n";
		}
	}
}
