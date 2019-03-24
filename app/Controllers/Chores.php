<?php namespace App\Controllers;
use App\Models\Dwarf;
use CodeIgniter\Controller;
use CodeIgniter\API\ResponseTrait;

class Chores extends Controller {

    use ResponseTrait;

	public function index() {
		$model = new Dwarf();
		$data = ['dwarves' => $model->getDwarves(),
                 'title' => 'Dwarves & Chores'];
		echo view('chores', $data);
	}

	public function show($id) {
	    $model = new Dwarf();
	    $data = $model->getDwarves($id);
    }

    static public function assign($id) {
	    $model = new Dwarf();
	    $dwarf = $model->getDwarves($id);
	    echo $dwarf['name'];
    }
}
