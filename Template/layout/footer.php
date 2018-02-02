<?php if ($this->user->hasProjectAccess('TaskModificationController', 'edit', $task['project_id'])): ?>
	<?= $this->modal->large(
			'edit', 
			'', 
			'TaskModificationController',
			'edit',
			array(
				'task_id' => $task['id'], 
				'project_id' => $task['project_id']
			)
		) ?>
<?php endif ?>
<?php if ($this->projectRole->canRemoveTask($task)): ?>
	<?= $this->modal->confirm(
			'trash-o',
			'',
			'TaskSuppressionController', 
			'confirm', 
			array(
				'task_id' => $task['id'], 
				'project_id' => $task['project_id']
			)
	) ?>
<?php endif ?>

<?php if (isset($task['is_active']) && $this->projectRole->canChangeTaskStatusInColumn($task['project_id'], $task['column_id'])): ?>
	    <?php if ($task['is_active'] == 1): ?>
		 <?= $this->modal->confirm(
			 'times',
			 '',
			 'TaskStatusController',
			 'close', 
			 array(
				 'task_id' => $task['id'], 
				 'project_id' => $task['project_id']
			 )
		 ) ?>
	    <?php else: ?>
		 <?= $this->modal->confirm(
			 'check-square-o',
			 '', 
			 'TaskStatusController', 
			 'open', 
			 array(
				 'task_id' => $task['id'], 
				 'project_id' => $task['project_id']
			 )
		 ) ?>
	    <?php endif ?>
<?php endif ?>

<?php if ($this->user->hasProjectAccess('TaskModificationController', 'edit', $task['project_id'])): ?>
		<?= $this->modal->confirm(
			'ban', 
			'', 
			'TaskCancellationController', 
			'cancel', 
			array(
				'plugin' => 'Instantactions', 
				'task_id' => $task['id'], 
				'project_id' => $task['project_id']
			)
		) ?>

<?php endif ?>








<style>
.fa.fa-times.fa-fw{
        color: gray;
}
.fa.fa-times.fa-fw:hover{ 
        color: black; 
}
  
.fa.fa-ban.fa-fw{
        color: gray;
}
.fa.fa-ban.fa-fw:hover{ 
        color: black; 
}
 
.fa.fa-edit.fa-fw{
        color: gray;
}
.fa.fa-edit.fa-fw:hover{ 
        color: black; 
}
 
.fa.fa-trash-o.fa-fw{
        color: gray;
}
.fa.fa-trash-o.fa-fw:hover{ 
        color: black; 
} 
</style>
