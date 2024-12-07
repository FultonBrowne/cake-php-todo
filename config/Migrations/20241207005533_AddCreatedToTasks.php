<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class AddCreatedToTasks extends BaseMigration
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
        $table = $this->table("tasks");
        $table
            ->addColumn("title", "string", ["limit" => 255, "null" => false])
            ->addColumn("is_done", "boolean", [
                "default" => false,
                "null" => false,
            ])
            ->addColumn("created", "datetime", [
                "default" => "CURRENT_TIMESTAMP",
            ])
            ->addColumn("modified", "datetime", [
                "default" => "CURRENT_TIMESTAMP",
            ])
            ->addForeignKey("user_id", "users", "id", [
                "delete" => "CASCADE",
                "update" => "NO_ACTION",
            ])
            ->update();
    }
}
