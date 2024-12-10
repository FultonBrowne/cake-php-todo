<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Task> $tasks
 * @var iterable<\App\Model\Entity\Tag> $tags
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

<!-- Filter Form -->
<div class="card card-body mb-3">
    <?= $this->Form->create(null, ["type" => "get"]) ?>
    <div class="row g-2 align-items-end">
      <div class="col-md-3">
        <?= $this->Form->control("is_done", [
            "type" => "select",
            "options" => ["" => "All", "0" => "Not Done", "1" => "Done"],
            "label" => "Completion Status",
            "class" => "form-select",
        ]) ?>
      </div>
      <div class="col-md-3">
        <?= $this->Form->control("tag_id", [
            "type" => "select",
            "options" => ["" => "All Tags"] + $tagsList,
            "label" => "Tag",
            "class" => "form-select",
        ]) ?>
      </div>
      <div class="col-md-2">
        <?= $this->Form->button("Filter", [
            "class" => "btn btn-secondary w-100",
        ]) ?>
      </div>
    </div>
    <?= $this->Form->end() ?>
</div>

<!-- Sorting Links -->
<div class="mb-3">
  <strong>Sort by:</strong>
  <?= $this->Paginator->sort("title", "Title") ?> |
  <?= $this->Paginator->sort("created", "Created Date") ?> |
  <?= $this->Paginator->sort("is_done", "Status") ?>
</div>

<table class="table table-striped task-table">
  <thead>
    <tr>
      <th><?= $this->Paginator->sort("title", "Title") ?></th>
      <th>Tags</th>
      <th><?= $this->Paginator->sort("is_done", "Done?") ?></th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($tasks as $task): ?>
      <tr class="<?= $task->is_done ? "completed-task" : "" ?>">
        <td><?= h($task->title) ?></td>
        <td>
          <?php foreach ($task->tags as $tag): ?>
            <span class="badge bg-info"><?= h($tag->name) ?></span>
          <?php endforeach; ?>
        </td>
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
                  "confirm" => "Are you sure?",
              ]
          ) ?>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<div class="pagination">
    <?= $this->Paginator->numbers() ?>
    <?= $this->Paginator->prev("Previous") ?>
    <?= $this->Paginator->next("Next") ?>
</div>
