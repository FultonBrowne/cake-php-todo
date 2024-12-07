<?php
declare(strict_types=1);

namespace App\Controller;

use Authentication\PasswordHasher\DefaultPasswordHasher;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Users->find();
        $users = $this->paginate($query);

        $this->set(compact("users"));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, contain: []);
        $this->set(compact("user"));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEmptyEntity();
        if ($this->request->is("post")) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__("The user has been saved."));

                return $this->redirect(["action" => "index"]);
            }
            $this->Flash->error(
                __("The user could not be saved. Please, try again.")
            );
        }
        $this->set(compact("user"));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, contain: []);
        if ($this->request->is(["patch", "post", "put"])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__("The user has been saved."));

                return $this->redirect(["action" => "index"]);
            }
            $this->Flash->error(
                __("The user could not be saved. Please, try again.")
            );
        }
        $this->set(compact("user"));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(["post", "delete"]);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__("The user has been deleted."));
        } else {
            $this->Flash->error(
                __("The user could not be deleted. Please, try again.")
            );
        }

        return $this->redirect(["action" => "index"]);
    }

    public function register()
    {
        $this->request->allowMethod(["get", "post"]);
        $user = $this->Users->newEmptyEntity();
        if ($this->request->is("post")) {
            $user = $this->Users->patchEntity($user, $this->request->getData());

            // Hash password
            $user->password = (new DefaultPasswordHasher())->hash(
                $user->password
            );

            if ($this->Users->save($user)) {
                $this->Flash->success(
                    "You have been registered. Please login."
                );
                return $this->redirect(["action" => "login"]);
            }
            $this->Flash->error("Registration failed. Please try again.");
        }
        $this->set(compact("user"));
    }

    public function login()
    {
        $this->request->allowMethod(["get", "post"]);
        $result = $this->Authentication->getResult();

        if ($result && $result->isValid()) {
            $redirect = $this->request->getQuery("redirect", [
                "controller" => "Tasks",
                "action" => "index",
            ]);

            return $this->redirect($redirect);
        } elseif ($this->request->is("post")) {
            $this->Flash->error("Invalid email or password");
        }
    }

    public function logout()
    {
        $this->Authentication->clearIdentity();
        return $this->redirect(["action" => "login"]);
    }

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        // Allow the login and register actions to be called without an authenticated user
        $this->Authentication->allowUnauthenticated(["login", "register"]);
    }
}
