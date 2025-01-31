<div class="flex flex-col items-center mt-20">
    <h1 class="text-4xl font-bold mb-4">Welcome to My Todo App</h1>
    <p class="text-xl text-gray-600 mb-8">Organize your tasks, track your progress, and stay productive.</p>
    <?php if ($this->request->getAttribute("identity")): ?>
        <!-- If logged in, direct to tasks -->
        <?= $this->Html->link(
            "View Your Tasks",
            ["controller" => "Tasks", "action" => "index"],
            ["class" => "bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded"]
        ) ?>
    <?php else: ?>
        <div class="space-x-4">
            <?= $this->Html->link(
                "Login",
                ["controller" => "Users", "action" => "login"],
                ["class" => "bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded"]
            ) ?>
            <?= $this->Html->link(
                "Register",
                ["controller" => "Users", "action" => "register"],
                ["class" => "bg-cyan-500 hover:bg-cyan-600 text-white font-medium py-2 px-4 rounded"]
            ) ?>
        </div>
    <?php endif; ?>
</div>
