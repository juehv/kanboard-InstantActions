<?php
namespace Kanboard\Plugin\Instantactions\Controller;
use Kanboard\Controller\BaseController;

/**
 *
 * @author   Max Eisel
 */
class InstaSettingsController extends BaseController
{
    /**
     * Instant Action Settingsgt
     *
     * @access public
     * @param array $values
     * @param array $errors
     */
    public function show(array $values = array(), array $errors = array())
    {
	    $project = $this->getProject();
	    $columnList =  $this->columnModel->getList($project['id']);
	    $colorList =  $this->colorModel->getList($project['id']);
	    $tagList =  $this->tagModel->getAll($project['id']);

	    if ( $this->projectMetadataModel->exists($project['id'], 'cancelColumn'))
	    {
		    if( empty($this->projectMetadataModel->get($project['id'], 'cancelColumn')))
		    {
                // cancelColumn does not exist
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
                // cancelColor does not exist
                $this->projectMetadataModel->save($project['id'],
				    array('cancelColor' => $this->colorModel->find( $this->colorModel->getDefaultColor()))); 
		    }
	    }else{
		    // cancelColor does not exist
		    $this->projectMetadataModel->save($project['id'],
			    array('cancelColor' => $this->colorModel->find( $this->colorModel->getDefaultColor()))); 
	    }

	    $destinationColumn 	= $this->projectMetadataModel->get($project['id'], 'cancelColumn');
	    $cancelColor 	= $this->projectMetadataModel->get($project['id'], 'cancelColor');
	    $cancelTags  	= $this->projectMetadataModel->get($project['id'], 'cancelTags');
		    

	


        $this->response->html($this->helper->layout->project('Instantactions:settings', array(
	//$this->response->html($this->helper->layout->project('project_edit/show', array(

            'owners' => $this->projectUserRoleModel->getAssignableUsersList($project['id'], true),
	    'values' => array(
	    	'column_id'	=> $this->projectMetadataModel->get($project['id'], 'cancelColumn'),
	    	'color_id'	=> $this->projectMetadataModel->get($project['id'], 'cancelColor'),
		),
            'errors' => $errors,
            'columns_list' => $columnList,
	    'destination' => $destinationColumn,
            'project' => $project,
            'title' => t('Edit project')
        )));
    }


    public function save()
    {

	    $values = $this->request->getValues();
	    $errors = array();
	    $project = $this->getProject();
	    $columnList =  $this->columnModel->getList($project['id']);
	    $this->projectMetadataModel->save($project['id'], array('cancelColumn' => $values["column_id"]));
	    $this->projectMetadataModel->save($project['id'], array('cancelColor' => $values["color_id"]));
	    //$this->projectMetadataModel->save($project['id'], array('cancelTags' => $values["tags"]));


	    return $this->show($values, $errors);
    }

}

?>
