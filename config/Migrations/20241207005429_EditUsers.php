<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class EditUsers extends BaseMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/migrations/4/en/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $this->table("tasks")
            ->addColumn("user_id", "integer", ["null" => false])
            ->addForeignKey("user_id", "users", "id", ["delete" => "CASCADE"])
            ->update();
    }
}
