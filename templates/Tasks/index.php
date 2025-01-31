<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Task> $tasks
 * @var iterable<\App\Model\Entity\Tag> $tags
 */
?>
<h1 class="text-3xl font-bold mb-6">Your Tasks</h1>

<div class="mb-6">
    <?= $this->Html->link(
        "Add New Task",
        ["action" => "add"],
        ["class" => "bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded"]
    ) ?>
</div>

<!-- Filter Form -->
<div class="bg-white shadow rounded-lg p-6 mb-6">
    <?= $this->Form->create(null, ["type" => "get"]) ?>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
        <div>
            <?= $this->Form->control("is_done", [
                "type" => "select",
                "options" => ["" => "All", "0" => "Not Done", "1" => "Done"],
                "label" => ["class" => "block text-sm font-medium text-gray-700 mb-1"],
                "class" => "mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500",
            ]) ?>
        </div>
        <div>
            <?= $this->Form->control("tag_id", [
                "type" => "select",
                "options" => ["" => "All Tags"] + $tagsList,
                "label" => ["class" => "block text-sm font-medium text-gray-700 mb-1"],
                "class" => "mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500",
            ]) ?>
        </div>
        <div>
            <?= $this->Form->button("Filter", [
                "class" => "w-full bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded",
            ]) ?>
        </div>
    </div>
    <?= $this->Form->end() ?>
</div>

<!-- Sorting Links -->
<div class="mb-6">
    <strong class="mr-2">Sort by:</strong>
    <?= $this->Paginator->sort("title", "Title", ["class" => "text-blue-600 hover:text-blue-800"]) ?> |
    <?= $this->Paginator->sort("created", "Created Date", ["class" => "text-blue-600 hover:text-blue-800"]) ?> |
    <?= $this->Paginator->sort("is_done", "Status", ["class" => "text-blue-600 hover:text-blue-800"]) ?>
</div>

<div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    <?= $this->Paginator->sort("title", "Title") ?>
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tags</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    <?= $this->Paginator->sort("is_done", "Done?") ?>
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            <?php foreach ($tasks as $task): ?>
                <tr class="<?= $task->is_done ? 'bg-gray-50' : '' ?>">
                    <td class="px-6 py-4 whitespace-nowrap"><?= h($task->title) ?></td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <?php foreach ($task->tags as $tag): ?>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                <?= h($tag->name) ?>
                            </span>
                        <?php endforeach; ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <?php if ($task->is_done): ?>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Yes</span>
                        <?php else: ?>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">No</span>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap space-x-2">
                        <?php if (!$task->is_done): ?>
                            <?= $this->Form->postLink(
                                "Mark as Done",
                                ["action" => "complete", $task->id],
                                [
                                    "class" => "inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700",
                                    "confirm" => "Mark this task as completed?",
                                ]
                            ) ?>
                        <?php endif; ?>
                        <?= $this->Html->link(
                            "Edit",
                            ["action" => "edit", $task->id],
                            ["class" => "inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-white bg-yellow-600 hover:bg-yellow-700"]
                        ) ?>
                        <?= $this->Form->postLink(
                            "Delete",
                            ["action" => "delete", $task->id],
                            [
                                "class" => "inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700",
                                "confirm" => "Are you sure?",
                            ]
                        ) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="mt-6 flex justify-center space-x-4">
    <?= $this->Paginator->numbers([
        "class" => "px-3 py-2 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50"
    ]) ?>
    <?= $this->Paginator->prev("Previous", [
        "class" => "px-3 py-2 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50"
    ]) ?>
    <?= $this->Paginator->next("Next", [
        "class" => "px-3 py-2 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50"
    ]) ?>
</div>
