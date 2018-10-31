<div>
	<h3><?= __('Expenses') ?></h3>
	<table class="ui celled table">
		<thead>
			<tr>
				<th><?= $this->Paginator->sort('id') ?></th>
				<th><?= $this->Paginator->sort('user_id') ?></th>
				<th><?= $this->Paginator->sort('start_date') ?></th>
				<th><?= $this->Paginator->sort('end_date') ?></th>
				<th><?= $this->Paginator->sort('amount') ?></th>
				<th><?= $this->Paginator->sort('next') ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($expenses as $expense): ?>
			<tr>
				<td><?= $this->Number->format($expense->id) ?></td>
				<td><?= $expense->has('user') ? $this->Html->link($expense->user->id, ['controller' => 'Users', 'action' => 'view', $expense->user->id]) : '' ?></td>
				<td><?= h($expense->start_date) ?></td>
				<td><?= h($expense->end_date) ?></td>
				<td><?= $this->Number->currency($expense->amount) ?></td>
				<td><?= $expense->next1[0]; ?></td>
				<td>
					<?= $this->Html->link(__('View'), ['action' => 'view', $expense->id]) ?>
					<?= $this->Html->link(__('Edit'), ['action' => 'edit', $expense->id]) ?>
					<?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $expense->id], ['confirm' => __('Are you sure you want to delete # {0}?', $expense->id)]) ?>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>
