<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Tasks Controller
 *
 * @property \App\Model\Table\TasksTable $Tasks
 */
class TasksController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $userId = $this->request->getAttribute("identity")->get("id");
        $isDone = $this->request->getQuery("is_done"); // '0', '1', or ''
        $tagId = $this->request->getQuery("tag_id"); // ID of tag or ''

        $query = $this->Tasks
            ->find()
            ->where(["Tasks.user_id" => $userId])
            ->contain([
                "Tags" => function ($q) use ($userId) {
                    return $q->where(["Tags.user_id" => $userId]);
                },
            ]);

        // Filter by is_done if specified
        if ($isDone !== null && $isDone !== "") {
            $query->where(["Tasks.is_done" => (bool) $isDone]);
        }

        // Filter by tag if specified
        if (!empty($tagId)) {
            // Match tasks having the specified tag
            $query->matching("Tags", function ($q) use ($tagId) {
                return $q->where(["Tags.id" => $tagId]);
            });
        }

        // Get the user’s tags for filtering
        $tagsList = $this->Tasks->Tags
            ->find("list")
            ->where(["Tags.user_id" => $userId])
            ->toArray();

        $tasks = $this->paginate($query);

        $this->set(compact("tasks", "tagsList"));
    }

    /**
     * View method
     *
     * @param string|null $id Task id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $task = $this->Tasks->get($id, contain: []);
        $this->set(compact("task"));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $userId = $this->request->getAttribute("identity")->get("id");
        $task = $this->Tasks->newEmptyEntity();

        if ($this->request->is("post")) {
            $task = $this->Tasks->patchEntity($task, $this->request->getData());
            $task->user_id = $userId;

            // Process new tags
            $newTagsString = $this->request->getData("new_tags");
            $tagIds = $this->processNewTags($newTagsString, $userId);

            // Merge new tags with selected existing tags
            $existingTagIds = (array) $task->get("tags._ids") ?: [];
            $task->set("tags._ids", array_merge($existingTagIds, $tagIds));

            if ($this->Tasks->save($task)) {
                $this->Flash->success(
                    "The task has been saved with your custom tags."
                );
                return $this->redirect(["action" => "index"]);
            }
            $this->Flash->error("Unable to add your task. Please try again.");
        }

        // Fetch user’s existing tags
        $tags = $this->Tasks->Tags
            ->find("list")
            ->where(["Tags.user_id" => $userId])
            ->toArray();

        $this->set(compact("task", "tags"));
    }

    /**
     * Edit method
     *
     * @param string|null $id Task id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $userId = $this->request->getAttribute("identity")->get("id");
        $task = $this->Tasks->get($id, [
            "contain" => ["Tags"],
        ]);

        // Ensure this task belongs to the logged-in user
        if ($task->user_id !== $userId) {
            $this->Flash->error("You are not authorized to edit this task.");
            return $this->redirect(["action" => "index"]);
        }

        if ($this->request->is(["post", "put", "patch"])) {
            $task = $this->Tasks->patchEntity($task, $this->request->getData());

            // Process new tags
            $newTagsString = $this->request->getData("new_tags");
            $newTagIds = $this->processNewTags($newTagsString, $userId);

            $existingTagIds = (array) $task->get("tags._ids") ?: [];
            $task->set("tags._ids", array_merge($existingTagIds, $newTagIds));

            if ($this->Tasks->save($task)) {
                $this->Flash->success("The task has been updated.");
                return $this->redirect(["action" => "index"]);
            }
            $this->Flash->error(
                "Unable to update your task. Please try again."
            );
        }

        // Fetch user’s existing tags
        $tags = $this->Tasks->Tags
            ->find("list")
            ->where(["Tags.user_id" => $userId])
            ->toArray();

        $this->set(compact("task", "tags"));
    }

    /**
     * Delete method
     *
     * @param string|null $id Task id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(["post", "delete"]);
        $task = $this->Tasks->get($id);
        if ($this->Tasks->delete($task)) {
            $this->Flash->success(__("The task has been deleted."));
        } else {
            $this->Flash->error(
                __("The task could not be deleted. Please, try again.")
            );
        }

        return $this->redirect(["action" => "index"]);
    }

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        // Deny access to tasks if not authenticated:
        $this->Authentication->addUnauthenticatedActions([]);
    }

    // src/Controller/TasksController.php
    public function complete($id = null)
    {
        $this->request->allowMethod(["post", "patch"]);
        $task = $this->Tasks->get($id);

        // Ensure that only the owner of the task can mark it as done
        $currentUser = $this->request->getAttribute("identity")->get("id");
        if ($task->user_id !== $currentUser) {
            $this->Flash->error(
                "You are not authorized to complete this task."
            );
            return $this->redirect(["action" => "index"]);
        }

        $task->is_done = true;
        if ($this->Tasks->save($task)) {
            $this->Flash->success("Task marked as completed!");
        } else {
            $this->Flash->error(
                "Could not mark the task as completed. Please try again."
            );
        }

        return $this->redirect(["action" => "index"]);
    }

    /**
     * Helper function to process new tags string
     *
     * @param string $newTagsString Comma-separated tags
     * @param int $userId Current user’s ID
     * @return array Array of tag IDs
     */
    protected function processNewTags($newTagsString, $userId)
    {
        $tagIds = [];
        if (!empty($newTagsString)) {
            $newTagsArray = array_map("trim", explode(",", $newTagsString));
            foreach ($newTagsArray as $newTagName) {
                if (!empty($newTagName)) {
                    // Check if tag exists for this user
                    $existingTag = $this->Tasks->Tags
                        ->find()
                        ->where(["name" => $newTagName, "user_id" => $userId])
                        ->first();

                    if ($existingTag) {
                        $tagIds[] = $existingTag->id;
                    } else {
                        // Create new tag
                        $newTag = $this->Tasks->Tags->newEntity([
                            "name" => $newTagName,
                            "user_id" => $userId,
                        ]);
                        if ($this->Tasks->Tags->save($newTag)) {
                            $tagIds[] = $newTag->id;
                        }
                    }
                }
            }
        }
        return $tagIds;
    }
}
