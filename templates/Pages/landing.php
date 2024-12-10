

<div class="text-center mt-5">
    <h1>Welcome to My Todo App</h1>
    <p class="lead">Organize your tasks, track your progress, and stay productive.</p>
    <?php if ($this->request->getAttribute("identity")): ?>
        <!-- If logged in, direct to tasks -->
        <?= $this->Html->link(
            "View Your Tasks",
            ["controller" => "Tasks", "action" => "index"],
            ["class" => "btn btn-primary"]
        ) ?>
    <?php else: ?>
        <?= $this->Html->link(
            "Login",
            ["controller" => "Users", "action" => "login"],
            ["class" => "btn btn-success me-2"]
        ) ?>
        <?= $this->Html->link(
            "Register",
            ["controller" => "Users", "action" => "register"],
            ["class" => "btn btn-info"]
        ) ?>
    <?php endif; ?>
</div>
