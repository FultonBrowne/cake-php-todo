<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Task> $tasks
 */
?>
<h1 class="mb-4">Your Tasks</h1>

<div class="mb-3">
  <?= $this->Html->link(
      "Add New Task",
      ["action" => "add"],
      ["class" => "btn btn-primary"]
  ) ?>
</div>

<table class="table table-striped task-table">
  <thead>
    <tr>
      <th>Title</th>
      <th>Done?</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($tasks as $task): ?>
      <tr class="<?= $task->is_done ? "completed-task" : "" ?>">
        <td><?= h($task->title) ?></td>
        <td>
          <?php if ($task->is_done): ?>
            <span class="badge bg-success">Yes</span>
          <?php else: ?>
            <span class="badge bg-secondary">No</span>
          <?php endif; ?>
        </td>
        <td>
          <?php if (!$task->is_done): ?>
            <?= $this->Form->postLink(
                "Mark as Done",
                ["action" => "complete", $task->id],
                [
                    "class" => "btn btn-sm btn-success me-1",
                    "confirm" => "Mark this task as completed?",
                ]
            ) ?>
          <?php endif; ?>
          <?= $this->Html->link(
              "Edit",
              ["action" => "edit", $task->id],
              ["class" => "btn btn-sm btn-warning me-1"]
          ) ?>
          <?= $this->Form->postLink(
              "Delete",
              ["action" => "delete", $task->id],
              [
                  "class" => "btn btn-sm btn-danger",
                  "confirm" => "Are you sure you want to delete this task?",
              ]
          ) ?>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
