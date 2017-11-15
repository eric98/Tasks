@extends('adminlte::layouts.app')

@section('htmlheader_title')
    Tasks
@endsection


@section('main-content')
    <script src="https://unpkg.com/vue"></script>

    <style>
        li.completed {
            text-decoration : line-through;
        }

        [v-cloak] { display: none; }

        li.active {
            background-color: blue;
        }
    </style>

    <div id="root">
        <ul>
            <li v-for="task in filteredTasks" :class="{ completed: isCompleted(task) }" @dblclick="updateTask(task)">
                <input type="text" v-model="newName" id="newName" v-if="task==editedTask"
                       @keyup.enter="editTask(task)" @keyup.esc="cancelEdit(task)">
                <div v-else>
                    @{{task.name}}
                    <i class="fa fa-pencil" aria-hidden="true" @click="updateTask(task)"></i>
                    <i class="fa fa-times" aria-hidden="true" @click="deleteTask(task) = null"></i>
                </div>
            </li>
        </ul>
        Tasques pendents: @{{ pendingTasks }}
        <br>
        Nova Tasca a afegir: <input type="text" v-model="newTask" id="newTask" @keyup.enter="addTask">
        <button id="add" @click="addTask">Afegir</button>

        <h2>Filtres</h2>

        <ul>
            <li @click="show('all')" :class="{ active: this.filter === 'all' }">All</li>
            <li @click="show('completed')" :class="{ active: this.filter === 'completed' }">Completed</li>
            <li @click="show('pending')" :class="{ active: this.filter === 'pending' }">Pending</li>
        </ul>
    </div>
    <script>
        // visibility filters
        var filters = {
            all: function (tasks) {
                return tasks
            },
            pending: function (tasks) {
                return tasks.filter(function (task) {
                    return !task.completed
                })
            },
            completed: function (tasks) {
                return tasks.filter(function (task) {
                    return task.completed
                })
            }
        }

        const LOCAL_STORAGE_KEY = 'TASKS'

        let vm = new Vue({
            el: '#root',
            data: {
                editedTask: null,
                filter: 'all',
                newName: '',
                newTask: '',
                tasks: []
            },
            watch: {
                // whenever question changes, this function will run
                tasks: function (newQuestion) {
                    console.log('Ha canviat watchers')
                    localStorage.setItem(LOCAL_STORAGE_KEY, JSON.stringify((this.tasks)))
                }
            },
            computed: {
                // a computed getter
                filteredTasks() {
                    return filters[this.filter](this.tasks)
                },
                pendingTasks() {
                    return filters['pending'](this.tasks).length
                }
            },
            methods: {
                show(filter) {
                    this.filter = filter
                },
                addTask() {
                    this.tasks.push({'name' : this.newTask, 'completed' : false})
                    this.newTask=''
                },
                isCompleted(task) {
                    return task.completed
                },
                deleteTask(task) {
                    this.tasks.splice(this.tasks.indexOf(task) , 1)
                },
                updateTask(task) {
                    this.newName = task.name
                    this.editedTask = task
                },
                editTask(task) {
                    this.editedTask.name=this.newName
                    this.editedTask = null
                },
                cancelEdit(task) {
                    this.editedTask = null
                },
                mounted() {
                    console.log('Inici')
                    //
//                this.tasks = localStorage.getItem()
//                this.newTasks = localStorage.setItem('NEW_TASK','Nova tasca')

                    this.tasks = JSON.parse(localStorage.getItem(LOCAL_STORAGE_KEY) || '[]')

//                JSON.parse Json -> Objecte -> Quan llegim de Local Storage
//                 JSON.stringify()-> Objecte a Json -> Guardar a la base de dades

                    // json_encode() | json_decode() PHP!!!!
                }
            }
        })

        // funció anonima o Closure
        //    document.querySelector('#add').addEventListener('click', () => {
        //        let newTask = document.querySelector('#newTask').value
        //        vm.tasks.push(newTask)
        //    })
    </script>
@endsection
