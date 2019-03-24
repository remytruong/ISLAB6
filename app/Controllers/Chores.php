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

        // Setting up models
        $dwarfmodel = new Dwarf();
        $taskmodel = new Task();
        $prioritymodel = new Priority();
        $groupmodel = new Group();

        // Getting the dwarf
        $dwarf = $dwarfmodel->getDwarves($id);
        
        // Building response data
        $resp = [
            'name' => $dwarf['name'],
            'role' => $dwarf['role'],
            'chores' => []
        ];

        $takentasks = [];
        for($i = 0; $i < 3; ++$i) {
          
            // Finding a random task
            $taskid = mt_rand(1, 15);
          
            while(in_array($taskid, $takentasks)) {
                $taskid = mt_rand(1, 15);
            }

            // Loading task data
            $taskdata = $taskmodel->getTasks($taskid);
            $prioritydata = $prioritymodel->getPriority($taskdata['priority']);
            $groupdata = $groupmodel->getGroups($taskdata['group']);

            // Building the task
            $task = [
                'id' => $taskdata['id'],
                'description' => $taskdata['task'],
                'priority' => $prioritydata['name'],
                'group' => $groupdata['name']
            ];

            // Inserting task into response
            array_push($resp['chores'], ['task'=> $task]);
        }

        // Returning as XML Response
        return $this->response->setXML($resp);
    }
}
