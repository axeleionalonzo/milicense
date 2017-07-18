<?php namespace App;


use Illuminate\Database\Eloquent\Model;

class Imei extends Model {

	protected $table = 'imei';
	protected $primaryKey = 'IMEI';

	protected $fillable = [
		'activation_id',
		'versionapp',
		'DeviceModel',
		'DeviceManufacturer'
	];
	public $timestamps = false;
	

	public function activation() {

		return $this->hasMany('App\Activation');
	}
}