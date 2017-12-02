<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BugReport extends Model
{
	protected $table = 'bug_reports';
	public $urlNamespace = 'bug_reports';
	protected $dates = ['created_at', 'solved_at'];
	protected $fillable = ['solved_at', 'description'];
	public $temporalField = 'created_at';

	// CODES

	const SOLVED = 1;
	const PENDING = 0;
	const ALL = 2;
}
