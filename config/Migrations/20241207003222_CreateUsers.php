<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateUsers extends BaseMigration
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
        $table = $this->table("users");
        $table
            ->addColumn("email", "string", ["limit" => 255, "null" => false])
            ->addColumn("password", "string", ["limit" => 255, "null" => false])
            ->addColumn("created", "datetime", [
                "default" => "CURRENT_TIMESTAMP",
            ])
            ->addColumn("modified", "datetime", [
                "default" => "CURRENT_TIMESTAMP",
            ])
            ->addIndex(["email"], ["unique" => true])
            ->create();
    }
}
