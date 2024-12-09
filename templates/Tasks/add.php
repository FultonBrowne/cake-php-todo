<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Task $task
 */
?>
<h1 class="mb-4">Login</h1>
<div class="card card-body" style="max-width: 400px; margin: 0 auto;">
    <?= $this->Form->create() ?>
    <div class="mb-3">
        <?= $this->Form->control("email", [
            "type" => "email",
            "class" => "form-control",
            "label" => ["class" => "form-label"],
            "placeholder" => "Enter your email",
        ]) ?>
    </div>
    <div class="mb-3">
        <?= $this->Form->control("password", [
            "type" => "password",
            "class" => "form-control",
            "label" => ["class" => "form-label"],
            "placeholder" => "Enter your password",
        ]) ?>
    </div>
    <?= $this->Form->button("Login", ["class" => "btn btn-primary w-100"]) ?>
    <?= $this->Form->end() ?>
</div>
