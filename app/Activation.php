<?php namespace App;


use Illuminate\Database\Eloquent\Model;

class Activation extends Model {

	protected $table = 'activation';
	protected $primaryKey = 'id';

	protected $fillable = [
		'activation_code',
		'number_of_device',
		'status',
		'branch_id',
		'project_id',
		'created_date',
		'expiry_date'
	];
	public $timestamps = false;

	public function imei() {

		return $this->belongsTo('App\Imei', 'id', 'activation_id');
	}

	public function projects() {

		return $this->belongsTo('App\Projects', 'project_id', 'project_id');
	}




}