<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Expense $expense
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $expense->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $expense->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Expenses'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="expenses form large-9 medium-8 columns content">
    <?= $this->Form->create($expense) ?>
    <fieldset>
        <legend><?= __('Edit Expense') ?></legend>
        <?php
            echo $this->Form->control('user_id', ['options' => $users]);
            echo $this->Form->control('rrule');
            echo $this->Form->control('start_date');
            echo $this->Form->control('end_date', ['empty' => true]);
            echo $this->Form->control('amount');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
