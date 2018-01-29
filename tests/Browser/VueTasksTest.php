<?php

namespace Tests\Browser;

use App\Task;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\VueTasksPage;
use Tests\DuskTestCase;

/**
 * Class VueTasksTest.
 */
class VueTasksTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Set up tests.
     */
    public function setUp()
    {
        parent::setUp();
        initialize_task_permissions();
//        Artisan::call('passport:install');
//        $this->withoutExceptionHandling();
    }

    /**
     * Create user.
     *
     * @return mixed
     */
    protected function createUser()
    {
        return factory(User::class)->create();
    }

    /**
     * Assign role task manager.
     *
     * @param $user
     */
    protected function assignRoleTaskManager($user)
    {
        $user->assignRole('task-manager');
    }

    /**
     * @return mixed
     */
    protected function login($browser)
    {
        $user = $this->createUser();
        $this->assignRoleTaskManager($user);
        $browser->loginAs($user);

        return $user;
    }

    /**
     * List tasks.
     *
     * @test
     *
     * @return void
     */
    public function list_tasks()
    {
        $this->browse(function (Browser $browser) {
            $this->login($browser);
            $tasks = factory(Task::class, 5)->create();
            $browser->maximize();
            $browser->visit(new VueTasksPage())
                ->seeTitle('Tasques Vue')
                ->dontSeeAlert('Tasques Vue')
                ->seeBox('Tasques Vue')
                ->assertVue('tasks', $tasks->toArray(), '@tasks')
                ->seeTasks($tasks);
        });
    }

    /**
     * Reload.
     *
     * @test
     */
    public function reload()
    {
        $this->browse(function (Browser $browser) {
            $this->login($browser);
            $tasks = factory(Task::class, 5)->create();
            $browser->maximize();
            $browser->visit(new VueTasksPage())
                ->assertVue('tasks', $tasks->toArray(), '@tasks')
                ->seeTasks($tasks);

            $task = factory(Task::class)->create();

            $browser->reload()
//                ->assertVisible('div.overlay>.fa-refresh')
//                ->assertVue('loading', true, '@tasks')
//                ->waitUntilMissing('div.overlay>.fa-refresh')
                ->assertVue('loading', false, '@tasks')
                ->seeTask($task);
        });
    }

    /**
     * See completed tasks.
     *
     * @test
     */
    public function see_completed_tasks()
    {
        $this->browse(function (Browser $browser) {
            $this->login($browser);
            $users = factory(User::class, 3)->create();
            $tasks = [Task::create(['name' => 'Comprar llet', 'description' => 'Com sempre', 'user_id' => $users[0]->id, 'completed' => false]),
                Task::create(['name' => 'Comprar pa', 'description' => 'Com sempre', 'user_id' => $users[0]->id, 'completed' => false]),
                Task::create(['name' => 'EstudiarPHP', 'description' => 'Com sempre', 'user_id' => $users[0]->id, 'completed' => false])
            ];
            $completed_tasks = [
                Task::create(['name' => 'Fer 3 anys', 'description' => 'Com sempre', 'user_id' => $users[0]->id, 'completed' => true]),
                Task::create(['name' => 'Aprendre catala', 'description' => 'Com sempre', 'user_id' => $users[0]->id, 'completed' => true]),
                    Task::create(['name' => 'Ser music', 'description' => 'Com sempre', 'user_id' => $users[0]->id, 'completed' => true])
            ];

            $browser->maximize();
            $browser->visit(new VueTasksPage())
                ->applyCompletedFilter()
                ->seeTasks($completed_tasks)
                ->dontSeeTasks($tasks)
            ;
        });
    }

    /**
     * See pending tasks.
     *
     * @test
     */
    public function see_pending_tasks()
    {
        $this->browse(function (Browser $browser) {
            $this->login($browser);
            $users = factory(User::class, 3)->create();
            $tasks = [Task::create(['name' => 'Comprar llet', 'description' => 'Com sempre', 'user_id' => $users[0]->id, 'completed' => false]),
                Task::create(['name' => 'Comprar pa', 'description' => 'Com sempre', 'user_id' => $users[0]->id, 'completed' => false]),
                Task::create(['name' => 'EstudiarPHP', 'description' => 'Com sempre', 'user_id' => $users[0]->id, 'completed' => false])
            ];
            $completed_tasks = [
                Task::create(['name' => 'Fer 3 anys', 'description' => 'Com sempre', 'user_id' => $users[0]->id, 'completed' => true]),
                Task::create(['name' => 'Aprendre catala', 'description' => 'Com sempre', 'user_id' => $users[0]->id, 'completed' => true]),
                Task::create(['name' => 'Ser music', 'description' => 'Com sempre', 'user_id' => $users[0]->id, 'completed' => true])
            ];

            $browser->maximize();
            $browser->visit(new VueTasksPage())
                ->applyPendingFilter()
                ->seeTasks($tasks)
                ->dontSeeTasks($completed_tasks)
            ;
        });
    }

    /**
     * Add task.
     * //no ho faig perque s'hauria de tocar codi javascript per a tocar els editors quill o medium-editor
     * @test
     */
//    public function add_task()
//    {
//        $this->browse(function (Browser $browser) {
//            $this->login($browser);
//            $browser->maximize();
//            $task = factory(Task::class)->make();
//            //no ho faig perque s'hauria de tocar codi javascript per a tocar els editors quill o medium-editor
//            $browser->visit(new VueTasksPage())
//                ->store_task($task)
//                ->assertVue('creating', true, '@tasks') //  Test state
//                ->waitForSuccessfulCreateAlert($task) // TODO
//                ->assertVue('creating', false, '@tasks') //  Test state
//                ->seeTask($task);
//        });
//    }

    /**
     * Edit task.
     * //no ho faig perque s'hauria de tocar codi javascript per a tocar els editors quill o medium-editor
     * @test
     */
//    public function edit_task()
//    {
//        $this->browse(function (Browser $browser) {
//            $this->login($browser);
//            $browser->maximize();
//            $oldTask = factory(Task::class)->create();
//            $newtask = factory(Task::class)->make();
//            $newtask->id = $oldTask->id;
//            $browser->visit(new VueTasksPage())
//                ->update_task($newtask)
//                ->assertVue('submit_editing', true, '@tasks') //  Test state
//                ->waitForSuccessfulEditAlert($newtask) // TODO
//                ->assertVue('submit_editing', false, '@tasks') //  Test state
//                ->seeTask($newtask)
//                ->dontSeeTask($oldTask);
//        });
//    }

    /**
     * Cancel edit.
     * //no ho faig perque s'hauria de tocar codi javascript per a tocar els editors quill o medium-editor
     * @test
     */
//    public function cancel_edit()
//    {
//        $this->browse(function (Browser $browser) {
//            $this->login($browser);
//            $browser->maximize();
//            $oldTask = factory(Task::class)->create();
//            $newtask = factory(Task::class)->make();
//            $newtask->id = $oldTask->id;
//            $browser->visit(new VueTasksPage())
//                ->edit_task($newtask)
//                ->assertVue('editing', true, '@tasks') //  Test state
//                ->cancel_update()
//                ->assertVue('editing', false, '@tasks') //  Test state
//                ->seeTask($oldTask)
//                ->dontSeeTask($newtask);
//        });
//    }

    /**
     * Delete task.
     *
     * @test
     */
    public function delete_task()
    {
        $this->browse(function (Browser $browser) {
            $this->login($browser);
            $browser->maximize();
            $task = factory(Task::class)->create();
            $browser->visit(new VueTasksPage())
                ->destroy_task($task)
                ->assertVue('taskBeingDeleted', $task->id, '@tasks') //  Test state
                ->dontSeeTask($task)
                ->assertVue('taskBeingDeleted', null, '@tasks'); //  Test state
        });
    }

    /**
     * Cancel delete task.
     * @group ds
     * @test
     */
    public function cancel_delete_task()
    {
        $this->browse(function (Browser $browser) {
            $this->login($browser);
            $browser->maximize();
            $task = factory(Task::class)->create();
            $browser->visit(new VueTasksPage())
                ->delete($task)
                ->assertVue('deleting', true, '@tasks') //  Test state
                ->pause(1000)
                ->cancel_delete() // TODO
                ->assertVue('deleting', false, '@tasks') //  Test state
                ->seeTask($task);
        });
    }

    /**
     * Toogle complete task.
     * //no ho faig perque s'hauria de tocar codi javascript per a tocar el toggle-button
     * @test
     */
//    public function toogle_complete_task()
//    {
//        $this->browse(function (Browser $browser) {
//            $this->login($browser);
//            $browser->maximize();
//            $task = factory(Task::class)->create();
//            $browser->visit(new VueTasksPage())
//                ->toogle_complete($task)
//                ->assertVue('toogle_completion', true, '@tasks') //  Test state
//                ->waitForCompletedTask() // TODO
//                ->assertVue('toogle_completion', false, '@tasks') //  Test state
//                ->seeCompletedTask($task) //TODO
//                ->toogle_complete($task)
//                ->assertVue('toogle_completion', true, '@tasks') //  Test state
//                ->waitForUnCompletedTask() // TODO
//                ->assertVue('toogle_completion', false, '@tasks') //  Test state
//                ->seeUnCompletedTask($task); //TODO
//        });
//    }
}
