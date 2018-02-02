<?php
//namespace Kanboard\Controller;
namespace Kanboard\Plugin\Instantactions\Controller;
use Kanboard\Controller\BaseController;
use Kanboard\Core\Controller\AccessForbiddenException;
use Kanboard\Model\TaskModel;
use Kanboard\Formatter\BoardFormatter;


class TaskCancellationController extends BaseController
{
    //public function cancel(array $values = array(), array $errors = array())
    public function cancel()
    {
	$method = "asd";
	$template = 'Instantactions:cancel';
	$success_message = 'Task cancelled successfully.';
	$failure_message = 'Unable to cancel this task.';
	
	$project = $this->getProject();
	$task = $this->getTask();
		//$values = array();
		//$values = $task;
		//die(var_dump($values));
	//die ($this->request->getStringParam('confirmation'));
	if ($this->request->getStringParam('confirmation') === 'yes') {
	//die ($this->request->getStringParam('confirmation'));
            $this->checkCSRFParam();
		
		$values = array();
		$valuesx = $task;
		$tagsx = $this->taskTagModel->getTagsByTask($task['id']);
		//die(var_dump($valuesx));
		$values['id'] = $valuesx['id'];
		$values['title'] = $valuesx['title'];
		if ( $this->projectMetadataModel->exists($project['id'], 'cancelColumn'))
		{
			if( empty($this->projectMetadataModel->get($project['id'], 'cancelColumn')))
			{
                // cancelColumn is not set, setting default
				$this->projectMetadataModel->save($project['id'], 
				array('cancelColumn' => $this->columnModel->getLastColumnID($project['id'])));
			}
		}else{
			// cancelColum does not exist
			$this->projectMetadataModel->save($project['id'], 
				array('cancelColumn' => $this->columnModel->getLastColumnID($project['id'])));
		}
		if ( $this->projectMetadataModel->exists($project['id'], 'cancelColor'))
		{
			if ( empty($this->projectMetadataModel->get($project['id'], 'cancelColor')))
			{
                // cancelColor is not set, setting default
				$this->projectMetadataModel->save($project['id'],
				       array('cancelColor' => $this->colorModel->find( $this->colorModel->getDefaultColor()))); 
			}
		}else{
			// cancelColor does not exist
			$this->projectMetadataModel->save($project['id'],
				array('cancelColor' => $this->colorModel->find( $this->colorModel->getDefaultColor()))); 
		}


		$values['color_id'] = $this->projectMetadataModel->get($project['id'], 'cancelColor'); 
		#$values['tags'] = /*$valuesx['tags']; */array('', 'cancelled')  ;
		$values['time_spent'] = '0';
		$values['time_estimated'] = '0';
		$tagid = $this->tagModel->findOrCreateTag($project["id"], "cancelled");
		$this->taskTagModel->associateTag($values["id"], $tagid);

		///error_log("AAAAAAAAAAAAAAAAAAAAAA");
		//error_log(print_r($values, True));
		//error_log(var_dump($this->projectMetadataModel->get($project['id'], 'cancelColumn')));
		//$values['column_position'] = 4;
		//die(var_dump($values));
		//$cancel_tag_id = $this->tagModel->getIdByName($task['project_id'], 'cancelled'); //TODO excetion
	if (true){
		//$this->taskTagModel->associateTag($task['id'], $cancel_tag_id);
		$destinationColumn = $this->projectMetadataModel->get($project['id'], 'cancelColumn');
		$this->taskPositionModel->movePosition($task['project_id'], $task['id'], $destinationColumn, $task['position']);
		$this->taskModificationModel->update($values);
                $this->flash->success($success_message);
            } else {
                $this->flash->failure($failure_message);
            }

            $this->response->redirect($this->helper->url->to('BoardViewController', 'show', array('task_id' => $task['id'], 'project_id' => $task['project_id'])), true);
        } else {
            $this->response->html($this->template->render($template, array(
                'task' => $task, 
            )));
        }
    }
}
