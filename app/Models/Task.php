<?php namespace App\Models;
use CodeIgniter\Model;

class Task extends Model {
    protected $table = 'tasks';

    public function getTasks($id = null) {
        if(!$id) {
            return $this->findAll();
        }
        return $this->asArray()->where(['id'=>$id])->first();
    }


}