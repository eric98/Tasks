<template>
    <div>
        <div>
            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-description">
                Launch Default Modal
            </button>

            <div id="prova" class="editable">
                EDITOR 1
            </div>

            <!--<div class="modal fade" id="modal-description">-->
                <!--<div class="modal-dialog">-->
                    <!--<div class="modal-content">-->
                        <!--<div class="modal-header">-->
                            <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close">-->
                                <!--<span aria-hidden="true">&times;</span></button>-->
                            <!--<h4 class="modal-title">Description</h4>-->
                        <!--</div>-->
                        <!--<div class="modal-body">-->
                            <!--<div id="editor">-->
                                <!--{{task.description}}-->
                            <!--</div>-->
                        <!--</div>-->
                        <!--<div class="modal-footer">-->
                            <!--<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>-->
                            <!--<button type="button" class="btn btn-primary">Update</button>-->
                        <!--</div>-->
                    <!--</div>-->
                <!--</div>-->
                <!--&lt;!&ndash; /.modal-content &ndash;&gt;-->
            <!--</div>-->
            <!--&lt;!&ndash; /.modal-dialog &ndash;&gt;-->
        </div>
        <!--<widget :loading="loading">-->
            <p slot="title">Tasques</p>
            <div v-cloak>
                <!--versio nova-->
                <table class="table table-bordered table-hover">
                    <tbody><tr>
                        <div class="modal fade" id="modal-description">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title">Description</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div id="editor">
                                            lkajsdlkjasdlkjasldkj
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary">Update</button>
                                    </div>
                                </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                        <th style="width: 10px">#</th>
                        <th>Task</th>
                        <th>Completed</th>
                        <th>Description</th>
                        <th>Created at</th>
                        <th>Updated at</th>
                        <th>Actions</th>
                    </tr>
                    <tr v-for="(task, index) in filteredTasks" v-bind:class="{completed: task.completed}">
                        <td>{{ index + 1 }}</td>
                        <td>{{ task.name }}</td>
                        <td>
                            <toggle-button :value="true" @change="task.completed?completeTask(task):incompleteTask(task)" v-model="task.completed"/>
                            <!--<toggle-button :value="true" v-if="completedFilter" @change="completTask(task)" v-model="task.completed"/>-->
                            <!--<toggle-button :value="true" v-else @change="completTask(task)" v-model="!task.completed"/>-->
                            <!--<toggle-button :value="true" @change="completTask(task)" v-model="completedFilter ? !task.completed : task.completed"/>-->
                            <!--<input type="checkbox" :value="true" @click="completTask(task)" >-->
                            <!--task.completed: {{ task.completed }}-->
                            <!--completedFilter: {{ completedFilter }}-->
                        </td>
                        <td>
                            <div v-if="editor == 'quill'">
                                <button type="button" class="btn btn-warning" v-if="editor == 'quill'" data-toggle="modal" data-target="#modal-description"><span class="fa fa-pencil"></span></button>
                                {{ task.description }}
                            </div>
                            <medium-editor v-if="editor == 'medium-editor'" :text='task.description' v-on:edit='completeTask(task)'></medium-editor>
                        </td>
                        <td>
                            <a class="pull-right" data-toggle="tooltip" :title="task.created_at" v-text="human(task.created_at)"></a>
                        </td>
                        <td>
                            <a class="pull-right" data-toggle="tooltip" :title="task.updated_at" v-text="human(task.updated_at)"></a>
                        </td>
                        <td>
                            <button type="button" class="btn btn-success"><span class="glyphicon glyphicon-search"></span></button>
                            <button type="button" class="btn btn-danger"><span class="fa fa-trash-o" @click="deleteTask(task)"></span></button>
                        </td>
                    </tr>

                    </tbody></table>
                <!--versio vella-->
                <!--<ul>-->
                    <!--<li v-for="task in filteredTasks" v-bind:class="{completed: task.completed}"-->
                        <!--@dblclick="editTask(task)">-->
                        <!--<input type="text" v-model="newName" id="newName" v-if="task==editedTask"-->
                               <!--@keyup.enter="updateTask(task)" @keyup.esc="cancelEdit(task)">-->
                        <!--<div v-else>-->
                            <!--{{task.name}} -> {{task.completed}}-->
                            <!--<i class="fa fa-pencil" aria-hidden="true" @click="editTask(task)"></i>-->
                            <!--<i class="fa fa-refresh fa-spin" v-if="task.id === taskBeingDeleted"></i>-->
                            <!--<i class="fa fa-times" aria-hidden="true" @click="deleteTask(task)"></i>-->
                            <!--<i class="fa fa-check" aria-hidden="true" @click="completeTask(task)" v-model="task.completed"></i>-->
                        <!--</div>-->
                    <!--</li>-->
                <!--</ul>-->

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
        <!--</widget>-->

        <message title="Message" message="" color="info"></message>
    </div>
</template>

<style src="quill/dist/quill.snow.css"></style>

<style src="medium-editor/dist/css/medium-editor.min.css"></style>
<style src="medium-editor/dist/css/themes/default.min.css"></style>

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
  import Quill from 'quill'
  import MediumEditor from 'medium-editor'
  import editor from 'vue2-medium-editor'

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
  import moment from 'moment'
  import {config} from '../config/tasks.js'

  const API_URL = '/api/v1/tasks/'

  export default {
    components: {Users,'medium-editor': editor},
    data () {
      return {
        editor: config.editor,
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
      completedFilter() {
        return this.filter==='completed'
      },
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
      human(date) {
        return moment(date).fromNow()
      },
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
          this.tasks.push({name: this.form.name, description: "hola", user_id: this.form.user_id, completed: false})
          this.form.name = ''
        }).catch((error) => {
          flash(error.message)
        }).then(() => {
          this.creating = false
          this.$emit('loading', false)
        })
      },
      deleteTask (task) {
        this.$emit('loading', true)
        this.taskBeingDeleted = task.id
        axios.delete(API_URL + task.id).then((response) => {
          this.tasks.splice(this.tasks.indexOf(task), 1)
        }).catch((error) => {
          flash(error.message)
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
        }).catch((error) => {
          flash(error.message)
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
      completeTask(task){
        console.log('completat: ',task.completed)
        this.form.post('/api/v1/complete-task/'+task.id).then((response) => {
        }).catch((error) => {
          flash(error.message)
        }).then(() => {
          this.$emit('loading', false)
        })
      },
      incompleteTask(task){
        console.log('completat: ',task.completed)
        axios.delete('/api/v1/complete-task/'+task.id).then((response) => {
        }).catch((error) => {
          flash(error.message)
        }).then(() => {
          this.$emit('loading', false)
        }).then(
          this.taskBeingDeleted = null
        )
      }

    },
    mounted () {
      var quill = new Quill('#editor', {
        theme: 'snow'
      });

      new MediumEditor('.editable');

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
