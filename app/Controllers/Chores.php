<?php namespace App\Controllers;
use App\Models\Dwarf;
use CodeIgniter\Controller;
use CodeIgniter\API\ResponseTrait;

class Chores extends Controller {

    use ResponseTrait;

	public function index() {
		$model = new Dwarf();
		$data['dwarves'] = $model->getDwarves();
        return $this->respond($data['dwarves'], 200, 'yayeet');
	}

	public function show($id) {
	    $model = new Dwarf();
	    $data = $model->getDwarves($id);
	    return $this->respond($data, 200, 'yoot');
    }
}
