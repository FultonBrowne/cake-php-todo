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
        $tasks = $this->Tasks
            ->find("all")
            ->where(["Tasks.user_id" => $userId])
            ->orderAsc("Tasks.created");
        $this->set(compact("tasks"));
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
        $task = $this->Tasks->newEmptyEntity();
        if ($this->request->is("post")) {
            $task = $this->Tasks->patchEntity($task, $this->request->getData());
            $task->user_id = $this->request
                ->getAttribute("identity")
                ->get("id");
            if ($this->Tasks->save($task)) {
                $this->Flash->success("The task has been saved.");
                return $this->redirect(["action" => "index"]);
            }
            $this->Flash->error("Unable to add your task.");
        }
        $this->set(compact("task"));
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
        $task = $this->Tasks->get($id, contain: []);
        if ($this->request->is(["patch", "post", "put"])) {
            $task = $this->Tasks->patchEntity($task, $this->request->getData());
            if ($this->Tasks->save($task)) {
                $this->Flash->success(__("The task has been saved."));

                return $this->redirect(["action" => "index"]);
            }
            $this->Flash->error(
                __("The task could not be saved. Please, try again.")
            );
        }
        $this->set(compact("task"));
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
}
