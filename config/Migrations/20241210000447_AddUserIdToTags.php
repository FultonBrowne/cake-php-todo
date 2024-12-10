<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class AddUserIdToTags extends BaseMigration
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
        $this->table("tags")
            ->addColumn("user_id", "integer", ["null" => false, "default" => 0]) // or false if user must always be logged in
            ->addForeignKey("user_id", "users", "id", ["delete" => "CASCADE"])
            ->update();
    }
}
