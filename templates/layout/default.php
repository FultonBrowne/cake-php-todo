<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 * @var \App\View\AppView $this
 */

$cakeDescription = "CakePHP: the rapid development php framework"; ?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <title><?= $this->fetch("title") ?></title>

    <!-- Add Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <?= $this->fetch("script") ?>
    <?= $this->Html->css("custom") ?>
</head>
<body class="bg-gray-50">
    <nav class="bg-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center">
                    <a href="<?= $this->Url->build("/") ?>" class="text-white font-bold text-xl">
                        My Todo App
                    </a>
                </div>

                <!-- Mobile menu button -->
                <div class="flex md:hidden">
                    <button type="button" class="text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white">
                        <span class="sr-only">Open main menu</span>
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>

                <div class="hidden md:block">
                    <div class="flex items-center">
                        <div class="flex-1 flex items-center justify-center">
                            <?php if ($this->request->getAttribute("identity")): ?>
                                <?= $this->Html->link(
                                    "Tasks",
                                    ["controller" => "Tasks", "action" => "index"],
                                    ["class" => "text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium"]
                                ) ?>
                            <?php endif; ?>
                        </div>

                        <div class="ml-4 flex items-center">
                            <?php if ($this->request->getAttribute("identity")): ?>
                                <?= $this->Html->link(
                                    "Logout",
                                    ["controller" => "Users", "action" => "logout"],
                                    ["class" => "text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium"]
                                ) ?>
                            <?php else: ?>
                                <?= $this->Html->link(
                                    "Login",
                                    ["controller" => "Users", "action" => "login"],
                                    ["class" => "text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium"]
                                ) ?>
                                <?= $this->Html->link(
                                    "Register",
                                    ["controller" => "Users", "action" => "register"],
                                    ["class" => "text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium"]
                                ) ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mobile menu, show/hide based on menu state -->
            <div class="md:hidden">
                <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                    <?php if ($this->request->getAttribute("identity")): ?>
                        <?= $this->Html->link(
                            "Tasks",
                            ["controller" => "Tasks", "action" => "index"],
                            ["class" => "text-gray-300 hover:text-white block px-3 py-2 rounded-md text-base font-medium"]
                        ) ?>
                    <?php endif; ?>

                    <?php if ($this->request->getAttribute("identity")): ?>
                        <?= $this->Html->link(
                            "Logout",
                            ["controller" => "Users", "action" => "logout"],
                            ["class" => "text-gray-300 hover:text-white block px-3 py-2 rounded-md text-base font-medium"]
                        ) ?>
                    <?php else: ?>
                        <?= $this->Html->link(
                            "Login",
                            ["controller" => "Users", "action" => "login"],
                            ["class" => "text-gray-300 hover:text-white block px-3 py-2 rounded-md text-base font-medium"]
                        ) ?>
                        <?= $this->Html->link(
                            "Register",
                            ["controller" => "Users", "action" => "register"],
                            ["class" => "text-gray-300 hover:text-white block px-3 py-2 rounded-md text-base font-medium"]
                        ) ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
        <?= $this->Flash->render() ?>
        <?= $this->fetch("content") ?>
    </div>
</body>
</html>
