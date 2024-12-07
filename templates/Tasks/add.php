<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Task $task
 */
?>
<h1>Add Task</h1>
<?= $this->Form->create($task) ?>
<?= $this->Form->control("title", ["label" => "Task Title"]) ?>
<?= $this->Form->button("Save Task") ?>
<?= $this->Form->end() ?>
