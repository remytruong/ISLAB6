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
	    //setting up what models I need
	    $dwarfmodel = new Dwarf();
	    $taskmodel = new Task();
        $prioritymodel = new Priority();
        $groupmodel = new Group();

        //data of dwarf given the id
        $data = $dwarfmodel->getDwarves($id);

        //creating a new document for simpleXML
        $dom = new domDocument("1.0");
	    $dom->formatOutput = true;

	    //making root element dwarves (incase i want a list of dwarves in the future)
	    $root = $dom->appendChild(($dom->createElement("dwarves")));
	    $sxe = simplexml_import_dom($dom);

	    //adding individual dwarf
	    $dwarf = $sxe->addchild("dwarf");
        $dwarf->addChild("name", $data['name']);
        $dwarf->addChild("role", $data['role']);

        //creating chores child
        $chores = $dwarf->addChild("chores");

        //making sure i dont pick a task twice or thrice
        $takentasks = [];

        //for each task get their description, id, priority(name) and group(name)
        for($i = 0; $i < 3; ++$i)
        {
            $taskid = mt_rand(1, 15);
            while(in_array($taskid, $takentasks)) {
                $taskid = mt_rand(1, 15);
            }
            $taskdata = $taskmodel->getTasks($taskid);
            array_push($takentasks, $taskid);

            $task = $chores->addChild("task");

            $task->addchild("ID", $taskdata['id']);

            //making sure htmlspecialcharacters aren't messing anything up
            $task->addchild("Description", htmlspecialchars($taskdata['task']));
            $prioritydata = $prioritymodel->getPriority($taskdata['priority']);
            $task->addChild("priority", $prioritydata['name']);
            $groupdata = $groupmodel->getGroups($taskdata['group']);
            $task->addChild("group", $groupdata['name']);

        }

        //converting to an array to send as an XML easier
        $arr = json_decode( json_encode($sxe), 1);

        return $this->response->setXML($arr);
    }
}
