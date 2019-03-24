<?php namespace App\Controllers;
use App\Models\Dwarf;
use App\Models\Task;
use App\Models\Group;
use App\Models\Priority;
use CodeIgniter\Controller;
use CodeIgniter\API\ResponseTrait;
use DOMDocument;

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
	    return $data['name'];
    }

    public function assign($id) {

        $dwarfmodel = new Dwarf();
        $taskmodel = new Task();
        $prioritymodel = new Priority();
        $groupmodel = new Group();

        $dwarf = $dwarfmodel->getDwarves($id);
        
        $resp = [
            'name' => $dwarf['name'],
            'role' => $dwarf['role'],
            'chores' => []
        ];

        $takentasks = [];
        for($i = 0; $i < 3; ++$i) {
          
            $taskid = mt_rand(1, 15);
          
            while(in_array($taskid, $takentasks)) {
                $taskid = mt_rand(1, 15);
            }

            $taskdata = $taskmodel->getTasks($taskid);
            $prioritydata = $prioritymodel->getPriority($taskdata['priority']);
            $groupdata = $groupmodel->getGroups($taskdata['group']);

            $task = [
                'id' => $taskdata['id'],
                'description' => $taskdata['task'],
                'priority' => $prioritydata['name'],
                'group' => $groupdata['name']
            ];

            array_push($resp['chores'], ['task'=> $task]);
        }

        return $this->response->setXML($resp);
    }
}
