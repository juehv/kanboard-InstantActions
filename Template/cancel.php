<div class="page-header">
    <h2><?= t('Cancel a task') ?></h2>
</div>

<div class="confirm">
    <p class="alert alert-info">
        <?= t('Do you really want to cancel the task "%s" as well as all subtasks?', $task['title']) ?>
    </p>

    <?= $this->modal->confirmButtons(
        'TaskCancellationController',
        'cancel',
        array('plugin' => 'Instantactions', 'task_id' => $task['id'], 'project_id' => $task['project_id'], 'confirmation' => 'yes')
    ) ?>
</div>
