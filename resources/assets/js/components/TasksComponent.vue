<template>
    <div>
        <widget :loading="loading">
            <p slot="title">Tasques</p>
            <div v-cloak>

                <ul>
                    <li v-for="task in filteredTasks" :class="{ completed: isCompleted(task) }"
                        @dblclick="editTask(task)">
                        <input type="text" v-model="newName" id="newName" v-if="task==editedTask"
                               @keyup.enter="updateTask(task)" @keyup.esc="cancelEdit(task)">
                        <div v-else>
                            {{task.name}}
                            <i class="fa fa-pencil" aria-hidden="true" @click="editTask(task)"></i>
                            <i class="fa fa-refresh fa-spin" v-if="task.id === taskBeingDeleted"></i>
                            <i class="fa fa-times" aria-hidden="true" @click="deleteTask(task)"></i>
                            <i class="fa fa-check" aria-hidden="true" @click="completTask(task)"></i>
                        </div>
                    </li>
                </ul>
                Tasques pendents: {{ pendingTasks }}
                <br>
                <div class="btn-group">
                    <button @click="show('all')" type="button" class="btn btn-default" :class="{ 'btn-primary': this.filter === 'all' }">All</button>
                    <button @click="show('completed')" type="button" class="btn btn-default" :class="{ 'btn-primary': this.filter === 'completed' }">Completed</button>
                    <button @click="show('pending')" type="button" class="btn btn-default" :class="{ 'btn-primary': this.filter === 'pending' }">Pending</button>
                </div>
                <div class="form-group has-feedback" :class="{ 'has-error': form.errors.has('user_id') }">
                    <label for="user_id">User</label>
                    <transition name="fade">
                        <span v-text="form.errors.get('user_id')" v-if="form.errors.has('user_id')" class="help-block"></span>
                    </transition>
                    <!--<input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAASCAYAAABSO15qAAAAAXNSR0IArs4c6QAAAPhJREFUOBHlU70KgzAQPlMhEvoQTg6OPoOjT+JWOnRqkUKHgqWP4OQbOPokTk6OTkVULNSLVc62oJmbIdzd95NcuGjX2/3YVI/Ts+t0WLE2ut5xsQ0O+90F6UxFjAI8qNcEGONia08e6MNONYwCS7EQAizLmtGUDEzTBNd1fxsYhjEBnHPQNG3KKTYV34F8ec/zwHEciOMYyrIE3/ehKAqIoggo9inGXKmFXwbyBkmSQJqmUNe15IRhCG3byphitm1/eUzDM4qR0TTNjEixGdAnSi3keS5vSk2UDKqqgizLqB4YzvassiKhGtZ/jDMtLOnHz7TE+yf8BaDZXA509yeBAAAAAElFTkSuQmCC&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; cursor: auto;">-->
                    <users @select="userSelected" id="user_id" name="user_id" v-model="form.user_id" :value="form.user_id"></users>
                </div>
                <div class="form-group has-feedback" :class="{ 'has-error': form.errors.has('name') }">
                    <label for="name">Task name</label>
                    <transition name="fade">
                        <span v-text="form.errors.get('name')" v-if="form.errors.has('name')" class="help-block"></span>
                    </transition>
                    <input @input="form.errors.clear('name')" class="form-control" type="text" v-model="form.name" id="name" name="name" @keyup.enter="addTask">
                </div>

                <!--aqui al button :disabled he llevat la opció de que es deshabilite si hi ha erros, ja que si sel·lecciones l'usuari desprès de que et salte l'error, el botó no s'habilita-->
                <button :disabled="form.submitting" id="add" @click="addTask" class="btn btn-primary">
                    <i class="fa fa-refresh fa-spin fa-lg" v-if="form.submitting"></i>
                    Afegir
                </button>
            </div>
            <p slot="Footer">Footer</p>
        </widget>

        <message title="Message" message="" color="info"></message>
    </div>
</template>

<style>
    [v-cloak] {
        display: none;
    }
    li.completed {
        text-decoration: line-through;
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
        return !tasks.completed
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
      userSelected(user) {
        this.form.user_id = user.id
      },
      show (filter) {
        this.filter = filter
      },
      addTask () {
        this.$emit('loading', true)
        this.creating = true
        this.form.post(API_URL).then((response) => {
          this.tasks.push({name: this.form.name, user_id: this.form.user_id, completed: false})
          this.form.name = ''
//        }).catch((error) => {
//          flash(error.message)
        }).then(() => {
          this.creating = false
          this.$emit('loading', false)
        })
      },
      isCompleted (task) {
        return !task.completed
      },
      deleteTask (task) {
        this.$emit('loading', true)
        this.taskBeingDeleted = task.id
        axios.delete(API_URL + task.id).then((response) => {
          this.tasks.splice(this.tasks.indexOf(task), 1)
//        }).catch((error) => {
//          flash(error.message)
        }).then(() => {
          this.$emit('loading', false)
        }).then(
          this.taskBeingDeleted = null
        )
      },
      updateTask (task) {
        this.$emit('loading', true)
        axios.put(API_URL+task.id, {name: this.newName }).then((response) =>  {
          this.tasks[this.tasks.indexOf(task)].name = this.newName;
          this.newName = ''
          this.editedTask = null
//        }).catch((error) => {
//          flash(error.message)
        }).then(() => {
          this.$emit('loading', false)
        })
      },
      editTask (task) {
        this.editedTask = task
        this.newName = task.name
      },
      cancelEdit (task) {
        this.editedTask = null
      },
      completTask(task){
        this.$emit('loading', true)
        console.log(task.completed)
        axios.put(API_URL+task.id, {name: task.name }).then((response) =>  {
          this.tasks[this.tasks.indexOf(task)].completed = !task.completed;
          this.newName = ''
          this.editedTask = null
        }).catch((error) => {
          flash(error.message)
        }).then(() => {
          this.$emit('loading', false)
        })

      }

    },
    mounted () {
      console.log(this.tasks)

      // HTTP CLIENT
      //Promises
      this.$emit('loading', true)
      axios.get(API_URL).then((response) => {
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
