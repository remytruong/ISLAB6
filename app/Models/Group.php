<?php namespace App\Models;
use CodeIgniter\Model;

class Group extends Model {
    protected $table = 'groups';

    public function getGroups($id = null) {
        if(!$id) {
            return $this->findAll();
        }
        return $this->asArray()->where(['id'=>$id])->first();
    }


}