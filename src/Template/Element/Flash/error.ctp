<?php
if (!isset($params['escape']) || $params['escape'] !== false) {
	$message = h($message);
}
?>
<!-- <div class="message error" onclick="this.classList.add('hidden');"><?= $message ?></div> -->
<div class="ui warning message" onclick="this.classList.add('hidden');">
	<p>
		<?= $message ?>
	</p>
</div>
