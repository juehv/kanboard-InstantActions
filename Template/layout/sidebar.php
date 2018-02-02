<li 		
		<?= $this->app->checkMenuSelection('InstaSettingsController') ?>>
		<?= $this->url->link(t('Instant Actions'), 'InstaSettingsController', 'show', array('plugin' => 'Instantactions','project_id' => $project['id'])) ?>
		
</li>

