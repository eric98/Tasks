<template>
    <div>
        <widget :loading="loading">
            <p slot="title">Tasques</p>
            <div v-cloak>
                <table class="table table-bordered table-hover">
                    <tbody><tr>
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
                        <td>
                            <div v-if="editor == 'quill'">
                                <button v-bind:id="'name-'+task.id" type="button" class="btn btn-warning" v-if="editor == 'quill'" data-toggle="modal" data-target="#modal-description"><span class="fa fa-pencil"></span></button>
                                {{ task.name }}
                            </div>
                            <medium-editor v-bind:id="'name-'+task.id" v-else-if="editor == 'medium-editor'" :text='task.name' v-on:edit='updateNameTask(task)'></medium-editor></td>
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
                                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modal-description" @click="editTaskDescription(task)"><span class="fa fa-pencil"></span></button>
                                <button type="button" class="btn btn-success" @click="updateTaskBox(task,'description')"><span class="glyphicon glyphicon-eye-open"></span></button>
                                <p v-bind:id="'description-'+task.id">{{ task.description }}</p>

                                <div class="modal fade" id="modal-description">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title">Id Task: {{editedTask}}</h4>
                                            </div>
                                            <div class="modal-body">
                                                <quill-editor ref="myTextEditor" @change="updateNewDescriptionQuill($event.html)" :content=quillText v-bind:id="'description-'+task.id">
                                                </quill-editor>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" @click="cancelEdit()" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                                <button type="button" @click="updateDescriptionTask(task); updateTaskBox(task,'description',true);" class="btn btn-primary" data-dismiss="modal">Update</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <medium-editor v-bind:id="'description-'+task.id" v-else-if="editor == 'medium-editor'" :text='task.description' v-on:edit='updateDescriptionTask(task)'></medium-editor>
                        </td>
                        <td>
                            <a class="pull-right" data-toggle="tooltip" :title="task.created_at" v-text="human(task.created_at)"></a>
                        </td>
                        <td>
                            <a class="pull-right" data-toggle="tooltip" :title="task.updated_at" v-text="human(task.updated_at)"></a>
                        </td>
                        <td>
                            <!--<button type="button" class="btn btn-success" @click="showTask(task)"><span class="glyphicon glyphicon-search"></span></button>-->
                            <button type="button" class="btn btn-danger" @click="deleteTask(task)"><span class="fa fa-trash-o"></span></button>
                        </td>
                    </tr>

                    </tbody></table>

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
  import { quillEditor } from 'vue-quill-editor'
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

  const API_URL = '/api/v1/'
  const API_TASKS_URL = API_URL+'tasks/'

  export default {
    components: {Users,'medium-editor': editor,quillEditor},
    data () {
      return {
        quillText: '',
        editor: config.editor,
        loading: false,
        editedTask: null,
        filter: 'all',
        newName: '',
        newDescription: '',
        name: '',
        tasks: [],
        creating: false,
        taskBeingDeleted: null,
        form: new Form({user_id:'',name:''})
      }
    },
    computed: {
      // a computed getter
      editorQuill() {
        return this.$refs.myTextEditor.quill
      },
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
//    watch: {
//      tasks: function () {
//                localStorage.setItem(LOCAL_STORAGE_KEY, JSON.stringify(this.tasks))
//      }
//    },
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
      cancelEdit(){
        this.editedTask = null
        this.newDescription = null
        this.newName = null
      },
      updateTaskBox(task,property,editedFinal){
        this.quillText = this.newDescription
        var idTask
        if (!this.editedTask){
          idTask = task.id
        } else {
          idTask = this.editedTask
        }
        var descriptionBox
        this.filteredTasks.filter(function(o){
          if (o.id == idTask){
            descriptionBox = o[property]
          }
        })

        if(editedFinal){
          if (descriptionBox.startsWith('<p>') && descriptionBox.endsWith('</p>')){
            descriptionBox = this.quillText.substring(3,this.quillText.length-4)
          } else {
            descriptionBox = this.quillText
          }

          this.filteredTasks.filter(function(o){
            if (o.id == idTask){
              o[property] = descriptionBox
            }
          })
        }

        if (document.getElementById(property+"-"+idTask).innerHTML==descriptionBox) {
          descriptionBox = this.escapeHtml(descriptionBox)
        }

        document.getElementById("description-"+idTask).innerHTML=descriptionBox

        this.cancelEdit()

      },
      escapeHtml(text) {
        var map = {
          '&': '&amp;',
          '<': '&lt;',
          '>': '&gt;',
          '"': '&quot;',
          "'": '&#039;'
        };

        return text.replace(/[&<>"']/g, function(m) { return map[m]; });
      },
      showTask(task){
        console.log("description-"+task.id)
        document.getElementById("description-"+task.id).innerHTML=this.newDescription
      },
      addTask () {
        this.$emit('loading', true)
        this.creating = true
        this.form.post(API_TASKS_URL).then((response) => {
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
        axios.delete(API_TASKS_URL + task.id).then((response) => {
          this.tasks.splice(this.tasks.indexOf(task), 1)
        }).catch((error) => {
          flash(error.message)
        }).then(() => {
          this.$emit('loading', false)
        }).then(
          this.taskBeingDeleted = null
        )
      },
      updateNameTask (task) {
        this.$emit('loading', true)
        axios.put(API_TASKS_URL+task.id, {name: document.getElementById('name-'+task.id).innerHTML}).catch((error) => {
          flash(error.message)
        }).then(() => {
          this.$emit('loading', false)
        })
        console.log("NAME IN EXIT")
      },
      updateNewDescriptionQuill(text) {
//        if (this.newDescription.startsWith('<p>') && this.newDescription.endsWith('</p>')){
//          console.log('eliminant')
//          this.newDescription = text.substring(3,text.length-4)
//        }
        this.newDescription = text
//        console.log(text.substring(3,text.length-4))
      },
      updateDescriptionTask(task) {
        var idTask = task.id
        if (this.editor=='quill'){
          idTask=this.editedTask
        } else if (this.editor =='medium-editor'){
          this.newDescription = document.getElementById('description-'+task.id).innerHTML
        }
        this.$emit('loading', true)
        axios.put(API_URL+'description-task/'+idTask, {description: this.newDescription }).catch((error) => {
          flash(error.message)
        }).then(() => {
          this.$emit('loading', false)
        })
      },
      editTaskName (task) {
        this.editedTask = task.id
        this.newName = task.name
//        console.log('NAME:           '+task.name)
//        console.log('DESCRIPTION:    '+task.description)
//        this.updateDescriptionTask(task)
      },
      editTaskDescription(task){
        this.editedTask = task.id
        this.newDescription = task.description
        this.quillText = task.description
      },
      completeTask(task){
        this.form.post(API_URL+'complete-task/'+task.id).then((response) => {
        }).catch((error) => {
          flash(error.message)
        }).then(() => {
          this.$emit('loading', false)
        })
      },
      incompleteTask(task){
        axios.delete(API_URL+'complete-task/'+task.id).then((response) => {
        }).catch((error) => {
          flash(error.message)
        }).then(() => {
          this.$emit('loading', false)
        }).then(
          this.taskBeingDeleted = null
        )
      },
    },
    mounted () {
//      var quill = new Quill('#editor', {
//        theme: 'snow'
//      });

      new MediumEditor('.editable');

      // HTTP CLIENT
      //Promises
      this.$emit('loading', true)
      axios.get(API_TASKS_URL).then((response) => {
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
