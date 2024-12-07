<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Task> $tasks
 */
?>
<h1>Your Tasks</h1>
<?= $this->Html->link("Add New Task", ["action" => "add"]) ?>
<table>
  <tr><th>Title</th><th>Done?</th><th>Actions</th></tr>
  <?php foreach ($tasks as $task): ?>
    <tr>
      <td><?= h($task->title) ?></td>
      <td><?= $task->is_done ? "Yes" : "No" ?></td>
      <td>
        <?php if (!$task->is_done): ?>
          <?= $this->Form->postLink(
              "Mark as Done",
              ["action" => "complete", $task->id],
              ["confirm" => "Mark this task as completed?"]
          ) ?>
        <?php else: ?>
          <em>Completed</em>
        <?php endif; ?>
        <?= $this->Html->link("Edit", ["action" => "edit", $task->id]) ?>
        <?= $this->Form->postLink(
            "Delete",
            ["action" => "delete", $task->id],
            ["confirm" => "Are you sure?"]
        ) ?>
      </td>
    </tr>
  <?php endforeach; ?>
</table>
