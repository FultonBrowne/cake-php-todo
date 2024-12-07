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
  <?= $this->Html->css("style.css") ?>
  <?= $this->fetch("meta") ?>
  <?= $this->fetch("css") ?>
  <?= $this->fetch("script") ?>
</head>
<body>
  <nav>
    <?= $this->Html->link("Home", [
        "controller" => "Pages",
        "action" => "display",
        "home",
    ]) ?>
    <?php if ($this->request->getAttribute("identity")): ?>
      <?= $this->Html->link("Tasks", [
          "controller" => "Tasks",
          "action" => "index",
      ]) ?>
      <?= $this->Html->link("Logout", [
          "controller" => "Users",
          "action" => "logout",
      ]) ?>
    <?php else: ?>
      <?= $this->Html->link("Login", [
          "controller" => "Users",
          "action" => "login",
      ]) ?>
      <?= $this->Html->link("Register", [
          "controller" => "Users",
          "action" => "register",
      ]) ?>
    <?php endif; ?>
  </nav>
  <?= $this->Flash->render() ?>
  <?= $this->fetch("content") ?>
</body>
</html>
