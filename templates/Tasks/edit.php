<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Task $task
 */
?>
<h1 class="mb-4">Edit Task</h1>
<div class="card card-body">
    <?= $this->Form->create($task) ?>
    <div class="mb-3">
        <?= $this->Form->control("title", [
            "class" => "form-control",
            "label" => ["class" => "form-label"],
        ]) ?>
    </div>

    <div class="mb-3">
        <label class="form-label">Existing Tags</label>
        <?= $this->Form->control("tags._ids", [
            "type" => "select",
            "multiple" => "checkbox",
            "options" => $tags,
            "label" => false,
            "class" => "form-check-input",
            "value" => array_map(fn($t) => $t->id, $task->tags), // pre-select current tags
        ]) ?>
    </div>

    <div class="mb-3">
        <?= $this->Form->control("new_tags", [
            "type" => "text",
            "label" => "Add New Tags (comma separated)",
            "class" => "form-control",
            "placeholder" => "e.g. Urgent, Follow-up",
        ]) ?>
    </div>

    <div class="mb-3 form-check">
        <?= $this->Form->control("is_done", [
            "type" => "checkbox",
            "class" => "form-check-input",
            "label" => ["class" => "form-check-label", "text" => "Completed?"],
        ]) ?>
    </div>

    <?= $this->Form->button("Save Changes", ["class" => "btn btn-primary"]) ?>
    <?= $this->Form->end() ?>
</div>
