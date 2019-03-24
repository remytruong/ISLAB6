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

	    $data = $dwarfmodel->getDwarves($id);
	    $dom = new domDocument("1.0");
	    $dom->formatOutput = true;
	    $root = $dom->appendChild(($dom->createElement("dwarves")));
	    $sxe = simplexml_import_dom($dom);
	    $dwarf = $sxe->addchild("dwarf");
        $dwarf->addChild("name", $data['name']);
        $dwarf->addChild("role", $data['role']);
        $chores = $dwarf->addChild("chores");
        $takentasks = [];
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
            $task->addchild("Description", htmlspecialchars($taskdata['task']));
            $prioritydata = $prioritymodel->getPriority($taskdata['priority']);
            $task->addChild("priority", $prioritydata['name']);
            $groupdata = $groupmodel->getGroups($taskdata['group']);
            $task->addChild("group", $groupdata['name']);

        }

        $dom->loadXML($sxe->asXML());
	    //echo $dom->saveXML();
        return $this->respond($sxe->asXML());
    }
}
