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
    <!-- Bootstrap CSS -->
    <?= $this->Html->css(
        "https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
    ) ?>
    <?= $this->fetch("meta") ?>
    <?= $this->fetch("css") ?>
    <?= $this->fetch("script") ?>
    <?= $this->Html->css("custom") ?>
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
          <a class="navbar-brand" href="<?= $this->Url->build(
              "/"
          ) ?>">My Todo App</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
              <?php if ($this->request->getAttribute("identity")): ?>
                  <li class="nav-item"><?= $this->Html->link(
                      "Tasks",
                      ["controller" => "Tasks", "action" => "index"],
                      ["class" => "nav-link"]
                  ) ?></li>
              <?php endif; ?>
            </ul>
            <ul class="navbar-nav ms-auto">
              <?php if ($this->request->getAttribute("identity")): ?>
                  <li class="nav-item"><?= $this->Html->link(
                      "Logout",
                      ["controller" => "Users", "action" => "logout"],
                      ["class" => "nav-link"]
                  ) ?></li>
              <?php else: ?>
                  <li class="nav-item"><?= $this->Html->link(
                      "Login",
                      ["controller" => "Users", "action" => "login"],
                      ["class" => "nav-link"]
                  ) ?></li>
                  <li class="nav-item"><?= $this->Html->link(
                      "Register",
                      ["controller" => "Users", "action" => "register"],
                      ["class" => "nav-link"]
                  ) ?></li>
              <?php endif; ?>
            </ul>
          </div>
        </div>
    </nav>

    <div class="container mt-4">
        <?= $this->Flash->render() ?>
        <?= $this->fetch("content") ?>
    </div>

    <!-- Bootstrap JS -->
    <?= $this->Html->script(
        "https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    ) ?>
</body>
</html>
