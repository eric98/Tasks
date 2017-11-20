<template>
    <div>
        <widget :loading="loading">
            <p slot="title">Tasques</p>
            <div v-cloak>

                <ul>
                    <li v-for="task in filteredTasks" :class="{ completed: isCompleted(task) }"
                        @dblclick="updateTask(task)">
                        <input type="text" v-model="newName" id="newName" v-if="task==editedTask"
                               @keyup.enter="editTask(task)" @keyup.esc="cancelEdit(task)">
                        <div v-else>
                            {{task.name}}
                            <i class="fa fa-pencil" aria-hidden="true" @click="updateTask(task)"></i>
                            <i class="fa fa-refresh fa-spin" v-if="task.id === taskBeingDeleted"></i>
                            <i class="fa fa-times" aria-hidden="true" @click="deleteTask(task)"></i>
                        </div>
                    </li>
                </ul>
                Tasques pendents: {{ pendingTasks }}
                <br>
                <div class="form-group">
                    <label for="user_id">User</label>
                    <!--<input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">-->
                    <users id="user_id" name="user_id"></users>
                </div>
                <div class="form-group">
                    <label for="name">Task name</label>
                    <input class="form-control" type="text" v-model="form.name" id="name" @keyup.enter="addTask">
                </div>
                <button :diseabled="form.submitting" id="add" @click="addTask" class="btn btn-primary">
                    <i class="fa fa-refresh fa-spin" v-if="form.submitting"></i>
                    Afegir
                </button>

                <h2>Filtres</h2>

                <ul>
                    <li @click="show('all')" :class="{ active: this.filter === 'all' }">All</li>
                    <li @click="show('completed')" :class="{ active: this.filter === 'completed' }">Completed</li>
                    <li @click="show('pending')" :class="{ active: this.filter === 'pending' }">Pending</li>
                </ul>
            </div>
            <p slot="Footer">Footer</p>
        </widget>

        <message title="Message" message="" color="info"></message>
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

  import Users from './Users'
  import Form from 'acacha-forms'

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

  const API_URL = '/api/v1/tasks/'

  export default {
    components: {Users},
    data () {
      return {
        loading: false,
        editedTask: null,
        filter: 'all',
        newName: '',
        name: '',
        tasks: [],
        creating: false,
        taskBeingDeleted: null,
        form: new Form({user_id:'',name:''})
      }
    },
    computed: {
      // a computed getter
      filteredTasks () {
        return filters[this.filter](this.tasks)
      },
      pendingTasks () {
        return filters['pending'](this.tasks).length
      }
    },
    watch: {
      tasks: function () {
//                localStorage.setItem(LOCAL_STORAGE_KEY, JSON.stringify(this.tasks))
      }
    },
    methods: {
      show (filter) {
        this.filter = filter
      },
      addTask () {
        this.creating = true
        let url = API_URL
        this.form.post(url).then((response) => {
          this.tasks.push({name: this.form.name, user_id: this.form.user_id, completed: false})
          this.form.name = ''
        }).catch((error) => {
          flash(error.message)
        }).then(() => {
          this.creating = false
        })
      },
      isCompleted (task) {
        return task.completed
      },
      deleteTask (task) {
        let url = API_URL + task.id
        this.taskBeingDeleted = task.id
        axios.delete(url).then((response) => {
          this.tasks.splice(this.tasks.indexOf(task), 1)
        }).catch((error) => {
          flash(error.message)
        }).then(
          this.taskBeingDeleted = null
        )
      },
      updateTask (task) {
        this.newName = task.name
        this.editedTask = task
        let url = API_URL + task.id
//        axios.put(url, {name: task.name})
//          .then((response) => {
//          this.tasks.push({name: task.name, completed: false})
//        })
//          .catch((error) => {
//          flash(error.message)
//        })
      },
      editTask (task) {
        this.editedTask.name = this.newName
        this.editedTask = null
      },
      cancelEdit (task) {
        this.editedTask = null
      }

    },
    mounted () {
      console.log(this.tasks)

      // HTTP CLIENT
      let url = API_URL
      //Promises
      this.$emit('loading', true)
      axios.get(url).then((response) => {
        this.tasks = response.data
      }).catch((error) => {
        console.log(error)
        flash(error.message)
      }).then(() => {
        this.$emit('loading', false)
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
