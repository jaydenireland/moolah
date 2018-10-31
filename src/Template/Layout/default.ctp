<?php
use Cake\Core\Configure;
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
	<meta charset="utf-8">
	<title>
		<?= $this->fetch('title'); ?>
	</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<?= $this->Html->script(Configure::read('debug') ? '/semantic/semantic.js' : '/semantic/semantic.min.js'); ?>
	<?= $this->Html->css(Configure::read('debug') ? '/semantic/semantic.css' : '/semantic/semantic.min.css'); ?>
	<?= $this->Html->css('main.css'); ?>
</head>
<body>
	<div class="ui pointing menu">
		<div class="item">
			<h1>
				<?= Configure::read('App.name'); ?>
			</h1>
		</div>
		<a class="item">
			Home
		</a>
		<a class="item">
			Messages
		</a>
		<a class="item">
			Friends
		</a>
	</div>

	<?= $this->Flash->render() ?>

	<div class="ui middle aligned center aligned grid">
		<div class="column mainContent">
			<?= $this->fetch('content');?>
		</div>
	</div>
</body>
</html>
