<?php namespace App\Models;
use CodeIgniter\Model;

class Priority extends Model {
    protected $table = 'priorities';

    public function getPriority($id = null) {
        if(!$id) {
            return $this->findAll();
        }
        return $this->asArray()->where(['id'=>$id])->first();
    }


}