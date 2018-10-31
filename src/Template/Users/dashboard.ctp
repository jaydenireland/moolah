<?php foreach ($user->plaid_accounts as $plaid): ?>
	<h1><?= $plaid['balances']['item']['institution']['name']; ?></h1>
	<?php foreach ($plaid['balances']['accounts'] as $account): ?>
		<div class="ui relaxed divided list">
			<div class="item">
				<div class="content">
					<a class="header"><?= $account['name']; ?></a>
					<div class="description">
						<?= $this->Number->currency(
								$account['balances']['current']
							);
						?>
					</div>
				</div>
			</div>
		</div>
	<?php endforeach;?>
<?php endforeach; ?>
