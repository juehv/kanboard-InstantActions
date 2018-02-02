<?php if ($this->app->isAjax()): ?>
    <div class="page-header">
        <h2><?= $this->text->e($project['name']) ?> &gt; <?= t('Edit project') ?></h2>
    </div>
<?php else: ?>
    <div class="page-header">
        <h2><?= t('Edit project') ?></h2>
    </div>
<?php endif ?>


<form method="post" action="<?= $this->url->href('InstaSettingsController', 'save', array('plugin' => 'Instantactions', 'project_id' => $project['id'], 'redirect' => 'show')) ?>" autocomplete="off">
    <?= $this->form->csrf() ?>
    <?= $this->form->hidden('id', $values) ?>

    <fieldset>
        <legend><?= t('Cancel') ?></legend>
	<!--
	<?=  print_r($destination, TRUE) ?>
	</br>
	<?= var_dump($values) ?>
	</br>
	-->
	<?= $this->task->renderColorField($values) ?>
	<?= $this->task->renderColumnField($columns_list, $values, $errors) ?>
	<!--	
	Tag selector
	<?= $this->task->renderTagField($project) ?>
	-->
       <!-- <?= $this->form->label(t('Column to move to'), 'column') ?>
        <?= $this->form->select('column', $columns_list, $values) ?>
-->

    </fieldset>
    
    <?= $this->modal->submitButtons(array('tabindex' => 1)) ?>

</form>
