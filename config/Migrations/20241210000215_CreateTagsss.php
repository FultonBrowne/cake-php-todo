<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateTagsss extends BaseMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/migrations/4/en/migrations.html#the-change-method
     * @return void
     */
    public function change(): void
    {
        $this->table("tasks_tags")
            ->addColumn("task_id", "integer", ["null" => false])
            ->addColumn("tag_id", "integer", ["null" => false])
            ->addForeignKey("task_id", "tasks", "id", ["delete" => "CASCADE"])
            ->addForeignKey("tag_id", "tags", "id", ["delete" => "CASCADE"])
            ->addIndex(["task_id", "tag_id"], ["unique" => true])
            ->create();
    }
}
