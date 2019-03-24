<?php namespace App\Models;
use CodeIgniter\Model;

class Dwarf extends Model {
	protected $table = 'dwarfs';

	public function getDwarves($id = null) {
		if(!$id) {
			return $this->findAll();
		}
		return $this->asArray()->where(['id'=>$id])->first();
	}


}