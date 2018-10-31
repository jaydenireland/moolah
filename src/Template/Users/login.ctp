<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="users form">
<?= $this->Flash->render('auth') ?>
	<?= $this->Form->create() ?>
		<?= __('Please enter your username and password') ?>
		<?= $this->Form->control('username') ?>
		<?= $this->Form->control('password') ?>
	<?= $this->Form->button(__('Login')); ?>
	<?= $this->Form->end() ?>
</div>
