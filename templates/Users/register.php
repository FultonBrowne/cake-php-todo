<h1>Register</h1>
<?= $this->Form->create($user) ?>
<?= $this->Form->control("email") ?>
<?= $this->Form->control("password", ["type" => "password"]) ?>
<?= $this->Form->button("Register") ?>
<?= $this->Form->end() ?>
