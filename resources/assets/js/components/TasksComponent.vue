<template>
    <div v-cloak>
            <ul>
                <li v-for="task in filteredTasks" :class="{ completed: isCompleted(task) }"
                    @dblclick="updateTask(task)">
                    <input type="text" v-model="newName" id="newName" v-if="task==editedTask"
                           @keyup.enter="editTask(task)" @keyup.esc="cancelEdit(task)">
                    <div v-else>
                        {{task.name}}
                        <i class="fa fa-pencil" aria-hidden="true" @click="updateTask(task)"></i>
                        <i class="fa fa-times" aria-hidden="true" @click="deleteTask(task)"></i>
                    </div>
                </li>
            </ul>
            Tasques pendents: {{ pendingTasks }}
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
</template>

<style>
    li.completed {
        text-decoration: line-through;
    }

    [v-cloak] {
        display: none;
    }

    li.active {
        background-color: blue;
    }
</style>

<script>
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

    import { wait } from './utils.js'

    //    const LOCAL_STORAGE_KEY = 'TASKS'

    export default {
        data() {
            return {
                editedTask: null,
                filter: 'all',
                newName: '',
                newTask: '',
                tasks: []
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
        watch: {
            tasks: function () {
//                localStorage.setItem(LOCAL_STORAGE_KEY, JSON.stringify(this.tasks))
            }
        },
        methods: {
            show(filter) {
                this.filter = filter
            },
            addTask() {
                this.tasks.push({'name': this.newTask, 'completed': false})
                this.newTask = ''
            },
            isCompleted(task) {
                return task.completed
            },
            deleteTask(task) {
                this.tasks.splice(this.tasks.indexOf(task), 1)
            },
            updateTask(task) {
                this.newName = task.name
                this.editedTask = task
            },
            editTask(task) {
                this.editedTask.name = this.newName
                this.editedTask = null
            },
            cancelEdit(task) {
                this.editedTask = null
            }

        },
        mounted() {
//                this.tasks = JSON.parse(localStorage.getItem(LOCAL_STORAGE_KEY) || '[]')
            console.log(this.tasks)

            //TODO Connectat a Internet i agafam la llista de tasques
//                this.tasks = ???

            // HTTP CLIENT
            let url = '/api/tasks'
            //Promises
            this.$emit('loading',true)
            axios.get(url).then(wait(5000).then((response) => {
                this.tasks = response.data;
            }).catch((error) => {
                console.log(error)
                flash(error.message)
            }).then(() => {
                this.$emit('loading',false)
            })

//            setTimeout( () => {
//                component.hide()
//            },3000)

            // API HTTP amb JSON <- Web service
            // URL GET http://NOM_SERVIDOR/api/tasks
            // URL POST http://NOM_SERVIDOR/api/tasks
            // URL DELETE http://NOM_SERVIDOR/api/tasks/{task}
            // URL PUT/PATCH http://NOM_SERVIDOR/api/tasks/{task}
        }
    }
</script>
