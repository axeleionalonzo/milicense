<?php namespace App;


use Illuminate\Database\Eloquent\Model;

class Projects extends Model {

	protected $table = 'projects';
	protected $primaryKey = 'project_id';

	protected $fillable = [
		'project_name',
		'company_id',
		'number_of_devices'
	];
	public $timestamps = false;

	public function activation() {

		return $this->hasMany('App\Activation');
	}
	
}