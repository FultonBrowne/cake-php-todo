<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateTags extends BaseMigration
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
            ->addColumn("name", "string", ["limit" => 100, "null" => false])
            ->addColumn("created", "datetime", [
                "default" => "CURRENT_TIMESTAMP",
            ])
            ->addColumn("modified", "datetime", [
                "default" => "CURRENT_TIMESTAMP",
            ])
            ->addIndex(["name"], ["unique" => true])
            ->create();
    }
}
