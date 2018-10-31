<?php
$class = 'message';
if (!empty($params['class'])) {
	$class .= ' ' . $params['class'];
}
if (!isset($params['escape']) || $params['escape'] !== false) {
	$message = h($message);
}
?>
<div class="ui message <?= h($class) ?>" onclick="this.classList.add('hidden');">
	<div class="header">
		Changes in Service
	</div>
	<p>
		<?= $message ?>
	</p>
</div>
