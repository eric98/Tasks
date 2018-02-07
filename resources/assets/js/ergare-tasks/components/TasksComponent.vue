<template>
    <div>
        <widget :loading="loading">
            <button type="button" class="btn btn-success" @click="setEditorRadioButtonChecked()" data-backdrop="static" data-toggle="modal" data-target="#modal-options"><span class="glyphicon glyphicon-cog"></span></button>
            <button type="button" class="btn btn-warning" id="reload" @click="reload()">Reload tasks</button>
            <div class="modal fade" id="modal-options">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="modal-title">Editor per a la descripció:</h2>
                        </div>
                        <div class="modal-body">
                            <form>
                                <input id="quillRadioButton" type="radio" name="editorSelected" value="quill">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 942 559.9" width="52px" height="31px">
                                    <circle cx="749" cy="125.5" r="25.7" class="logo"></circle>
                                    <path d="M643.3 211.5c0 21.2 0 76.5 0 91.8 0 19.5-3.5 90.9-76.1 90.9-75.9 0-74.3-71.3-74.3-98.8 0-23.4 0-70.4 0-83.8h-39v94.1s-8.1 128.5 111.3 128.5c119.4 0 115.4-124.5 115.4-124.5v-98.2h-37.3zM816.5 45.2H855v378.5h-38.5zM504 472.7c-79.4 0-194.9-12-268.3-12.8-12.2 0-23 1.5-32.6 3.9l13-11.6c14.3-12.9 37.6-20.9 43.4-22 94.4-18.6 164.8-93.7 164.8-212.8C424.3 83.2 329.3 0 212.1 0S0 76.9 0 217.3c0 126.8 84.9 208 193.1 216.5 0 0 5.7.1 6.4 3.6.6 3.1-4.8 7.6-4.8 7.6l-64.4 59.6 12.4 13.4 23.8-21.3c13.3-10.6 35.1-23.6 62.1-23.6 89.3 0 188.2 89.1 280.1 86.9 134.4-3.2 165.7-93 169.1-104.6.2-.4-55.6 17.3-173.8 17.3zM39.4 217.3c0-114.3 77.3-177 172.8-177 95.4 0 172.8 67.7 172.8 177 0 112.6-77.3 177-172.8 177-95.5-.1-172.8-67.8-172.8-177zM903.5 45.2H942v378.5h-38.5zM729.5 211.1H768v212.5h-38.5z" class="logo"></path>
                                </svg>
                                <p style="clear:none; font-size: 1em;"><input id="medium-editorRadioButton" type="radio" name="editorSelected" value="medium-editor">
                                    <strong>Medium<span style="color: #FFAA37;">Editor</span></strong><br></p>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <p>Actual: <svg v-if="editor == 'quill'" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 942 559.9" width="52px" height="31px">
                                <circle cx="749" cy="125.5" r="25.7" class="logo"></circle>
                                <path d="M643.3 211.5c0 21.2 0 76.5 0 91.8 0 19.5-3.5 90.9-76.1 90.9-75.9 0-74.3-71.3-74.3-98.8 0-23.4 0-70.4 0-83.8h-39v94.1s-8.1 128.5 111.3 128.5c119.4 0 115.4-124.5 115.4-124.5v-98.2h-37.3zM816.5 45.2H855v378.5h-38.5zM504 472.7c-79.4 0-194.9-12-268.3-12.8-12.2 0-23 1.5-32.6 3.9l13-11.6c14.3-12.9 37.6-20.9 43.4-22 94.4-18.6 164.8-93.7 164.8-212.8C424.3 83.2 329.3 0 212.1 0S0 76.9 0 217.3c0 126.8 84.9 208 193.1 216.5 0 0 5.7.1 6.4 3.6.6 3.1-4.8 7.6-4.8 7.6l-64.4 59.6 12.4 13.4 23.8-21.3c13.3-10.6 35.1-23.6 62.1-23.6 89.3 0 188.2 89.1 280.1 86.9 134.4-3.2 165.7-93 169.1-104.6.2-.4-55.6 17.3-173.8 17.3zM39.4 217.3c0-114.3 77.3-177 172.8-177 95.4 0 172.8 67.7 172.8 177 0 112.6-77.3 177-172.8 177-95.5-.1-172.8-67.8-172.8-177zM903.5 45.2H942v378.5h-38.5zM729.5 211.1H768v212.5h-38.5z" class="logo"></path>
                            </svg>
                                <strong v-else-if="editor == 'medium-editor'">Medium<span style="color: #FFAA37;">Editor</span></strong><br>
                            </p>
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                            <button type="button" @click="updateEditor()" class="btn btn-primary" data-dismiss="modal">Update</button>
                        </div>
                    </div>
                </div>
            </div>
            <p slot="title">Tasques Vue</p>
            <div v-cloak>
                <table id="task-table" class="table table-bordered table-hover">
                    <tbody><tr>
                        <th>#</th>
                        <th>Id Task</th>
                        <th>Task</th>
                        <th>Completed</th>
                        <th>Description</th>
                        <th>User name</th>
                        <th>Created at</th>
                        <th>Updated at</th>
                        <th>Actions</th>
                    </tr>
                    <tr v-for="(task, index) in filteredTasks" v-bind:class="{completed: task.completed}">
                        <td><b>{{ index + 1 }}</b></td>
                        <td>{{ task.id }}</td>
                        <td>
                            <div>
                                <input type="text" v-model="newName" id="newName" v-if="task==editedTask"
                                       @keyup.enter="updateNameTask(task)" @keyup.esc="cancelEdit(task)">
                                <div v-else v-bind:id="'name-'+task.id" @dblclick="editTaskName(task)">
                                    {{task.name}}
                                </div>
                            </div>
                        <td>
                            <toggle-button :sync="true" @change="task.completed?completeTask(task):incompleteTask(task)" v-model="task.completed"/>
                        </td>
                        <td>
                            <div v-if="editor == 'quill'">
                                <button type="button" class="btn btn-warning" data-backdrop="static" data-toggle="modal" data-target="#modal-description" @click="editTaskDescription(task)"><span class="fa fa-pencil"></span></button>
                                <button type="button" class="btn btn-success" @click="updateTaskBox(task,'description'); changeEyeIcon('eye-description-'+task.id);"><span v-bind:id="'eye-description-'+task.id" class="glyphicon glyphicon-eye-open"></span></button>
                                <p class="description" v-bind:id="'description-'+task.id" v-html="task.description"></p>

                                <div class="modal fade" id="modal-description">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" @click="cancelEdit()" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title">Id Task: {{editedTask}}</h4>
                                            </div>
                                            <div class="modal-body">
                                                <quill-editor ref="myTextEditor" @change="updateNewTextQuill($event.html,'description')" :content=quillText v-bind:id="'description-'+task.id">
                                                </quill-editor>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" @click="cancelEdit()" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                                <button type="button" @click="updateTaskBox(task,'description',true); updateDescriptionTask(task);cancelEdit();" class="btn btn-primary" data-dismiss="modal">Update</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <medium-editor v-bind:id="'description-'+task.id" v-else-if="editor == 'medium-editor'" class="description" :text='task.description' v-on:edit='updateDescriptionTask(task)'></medium-editor>
                        </td>
                        <td>
                            <div v-if="editingUserId!=task.id">
                                <button type="button" class="btn btn-warning" @click="editTaskUserId(task)"><span class="fa fa-pencil"></span></button>
                                {{ showUserName(task) }}
                            </div>
                            <div v-else="editingUserId!=task.id">
                                <button type="button" class="btn btn-success" @click="updateUserIdTask(task); cancelEdit();"><span class="fa fa-check"></span></button>
                                <button type="button" class="btn btn-danger" @click="cancelEdit()"><span class="fa fa-times"></span></button>
                                <users @select="userEditedSelected" v-model="task.user_id" :value="newUserId"></users>
                            </div>

                            <!--<input type="text" v-model="newName" id="newName" v-if="task==editedTask"-->
                                   <!--@keyup.enter="updateUserIdTask(task)" @keyup.esc="cancelEdit(task)">-->
                            <div v-else v-bind:id="'userName-'+task.id" @dblclick="editTaskName(task)">
                                {{ showUserName(task) }}
                            </div>
                        </td>
                        <td>
                            <a class="pull-right" data-toggle="tooltip" :title="task.created_at" v-text="human(task.created_at)"></a>
                        </td>
                        <td>
                            <a class="pull-right" data-toggle="tooltip" :title="task.updated_at" v-text="human(task.updated_at)"></a>
                        </td>
                        <td>
                            <button type="button" class="btn btn-success" data-backdrop="static" data-toggle="modal" data-target="#modal-task" @click="showTask(task)"><span class="glyphicon glyphicon-search"></span></button>
                            <button :id="'delete-task-'+task.id" type="button" class="btn btn-danger" data-backdrop="static" data-toggle="modal" data-target="#modal-task" @click="showTaskToDelete(task)"><span class="fa fa-trash-o"></span></button>

                            <div class="modal fade" id="modal-task">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h2 v-if="deleting">Esteu segur de borrar aquesta tasca? </h2>
                                        </div>
                                        <div class="modal-body">
                                            <ul>
                                                <li>Id: {{ showedTask.id }}</li>
                                                <li>Name: {{ showedTask.name }}</li>
                                                <li id="show-description">Description: </li>
                                                <li>Completed: {{ showedTask.completed?'Yes':'No' }}</li>
                                                <li>User_id: {{ showedTask.user_id }}</li>
                                                <li>User name: {{ showedTaskUserName }}</li>
                                                <li>Created at: {{ human(showedTask.created_at) }}, {{ showedTask.created_at }}</li>
                                                <li>Updated at: {{ human(showedTask.updated_at) }}, {{ showedTask.updated_at }}</li>
                                            </ul>

                                        </div>
                                        <div class="modal-footer">
                                            <div v-if="!deleting">
                                                <button @click="cancelShow()" type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                                <button v-if="getTaskPos(showedTask)!=0" type="button" @click="showTask(afterBeforeTask(false))"><span><</span></button>
                                                <button v-if="!isLastTaskFiltered(showedTask)"type="button" @click="showTask(afterBeforeTask(true))"><span>></span></button>
                                            </div>
                                            <div v-else="!deleting">
                                                <button id="cancel-delete-task" @click="cancelShow()" type="button" class="btn btn-success pull-left" data-dismiss="modal">NO</button>
                                                <button id="destroy-task" class="btn btn-danger" type="button" @click="deleteTask(showedTask);cancelShow()" data-dismiss="modal"><span>SI</span></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    </tbody></table>

                Tasques pendents: {{ pendingTasks }} <br>
                Tasques filtrades: {{ filteredTasks.length }}
                <br>
                <div class="btn-group">
                    <button @click="show('all')" type="button" class="btn btn-default" :class="{ 'btn-primary': this.filter === 'all' }">All</button>
                    <button id="completed-tasks" @click="show('completed')" type="button" class="btn btn-default" :class="{ 'btn-primary': this.filter === 'completed' }">Completed</button>
                    <button id="pending-tasks" @click="show('pending')" type="button" class="btn btn-default" :class="{ 'btn-primary': this.filter === 'pending' }">Pending</button>
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

                <div class="form-group has-feedback" :class="{ 'has-error': form.errors.has('description') }">
                    <label for="description">Task description</label>
                    <transition name="fade">
                        <span v-text="form.errors.get('description')" v-if="form.errors.has('description')" class="help-block"></span>
                    </transition>
                    <quill-editor v-if="editor == 'quill'" v-model="form.description" id="description" name="description" @input="form.errors.clear('description')" ref="myTextEditor" @change="updateNewTextQuill($event.html,'description')" :content=quillText>
                    </quill-editor>
                    <medium-editor v-model="form.description" id="description" name="description" @input="form.errors.clear('description')" v-else-if="editor == 'medium-editor'" class="description" text="<i>Insert text here ...<i>"></medium-editor>
                    <!--<input @input="form.errors.clear('description')" class="form-control" type="text" v-model="form.description" id="description" name="description" @keyup.enter="addTask">-->
                </div>

                <!--aqui al button :disabled he llevat la opció de que es deshabilite si hi ha erros, ja que si sel·lecciones l'usuari desprès de que et salte l'error, el botó no s'habilita-->
                <button :disabled="form.submitting" id="store-task" @click="addTask" class="btn btn-primary">
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
    .description{
        max-width: 500px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
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

  import createApiTask from './tasks/api/tasks';
  import createApiDescriptionTask from './tasks/api/descriptionTasks';
  import createApiUserIdTask from './tasks/api/userIdTasks';
  import createApiCompleteTask from './tasks/api/completeTasks';
  import createApiUsers from './tasks/api/users';

  const crudTask = createApiTask(API_TASKS_URL);
  const crudTaskDescription = createApiDescriptionTask(API_URL+'description-task/');
  const crudTaskUserId = createApiUserIdTask(API_URL+'user_id-task/');
  const crudTaskComplete = createApiCompleteTask(API_URL+'complete-task/');
  const crudUsers = createApiUsers(API_URL+'users/');

  export default {
    components: {Users,'medium-editor': editor,quillEditor},
    data () {
      return {
        showedTask:'',
        showedTaskUserName:'',
        quillText: '',
        loading: true,
        editedTask: null,
        editingUserId: false,
        filter: 'all',
        newName: '',
        newDescription: '',
        newUserId: '',
        name: '',
        tasks: [],
        users: [],
        creating: false,
        deleting: false,
        taskBeingDeleted: null,
        form: new Form({user_id:'',name:'',description:''})
      }
    },
    computed: {
      editor() {
        if (localStorage.getItem('editor') == null){
          localStorage.setItem('editor',config.editor)
        }
        return localStorage.getItem('editor')
      },
      completedFilter() {
        return this.filter==='completed'
      },
      filteredTasks () {
        return filters[this.filter](this.tasks)
      },
      pendingTasks () {
        return filters['pending'](this.tasks).length
      },
    },
    methods: {
      human(date) {
        return moment(date).fromNow()
      },
      userSelected(user) {
        this.form.user_id = user.id
      },
      userEditedSelected(user) {
        this.newUserId = user.id
      },
      show(filter) {
        this.filter = filter
      },
      setEditorRadioButtonChecked(){
        document.getElementById(localStorage.getItem('editor')+"RadioButton").setAttribute("checked",true)
      },
      updateEditor(){
        var radios = document.getElementsByName('editorSelected');

        for (var i = 0, length = radios.length; i < length; i++)
        {
          if (radios[i].checked)
          {
            console.log(localStorage.getItem('editor'))
            localStorage.setItem('editor', radios[i].value)
            window.location.reload()
            break
          }
        }
      },
      reload(){
        this.tasks = []
        this.fetchTasks()
      },
      isLastTaskFiltered(task){
        var length = this.filteredTasks.length

        return this.getTaskPos(task)+1 == length
      },
      getTaskPos(task){
        for (var i = 0; i < this.filteredTasks.length; i++) {
          if (this.filteredTasks[i] == task){
            return i
          }
        }
      },
      afterBeforeTask(after){
        var op
        if (after) {
          op = 1
        } else {
          op = -1
        }
        for (var i = 0; i < this.filteredTasks.length; i++) {
          if (this.filteredTasks[i] == this.showedTask){
            return this.filteredTasks[i+op]
          }
        }
      },
      changeEyeIcon(id){

        var eyesOpen = false

        if (document.getElementById(id).getAttribute("class") == 'glyphicon glyphicon-eye-open'){
          eyesOpen = true
        }

        if (eyesOpen) {
          document.getElementById(id).setAttribute("class","glyphicon glyphicon-eye-close")
        } else {
          document.getElementById(id).setAttribute("class","glyphicon glyphicon-eye-open")
        }
      },
      cancelEdit(){
        this.editedTask = null
        this.editingUserId = false
        this.newDescription = null
        this.newName = null
        this.quillText = null
      },
      updateTaskBox(task,property,editedFinal){
        if (property == 'name'){
          this.quillText = this.newName
        } else if (property == 'description'){
          this.quillText = this.newDescription
        }
        var idTask
        if (!this.editedTask){
          idTask = task.id
        } else {
          idTask = this.editedTask
        }
        var textBox
        this.filteredTasks.filter(function(task){
          if (task.id == idTask){
            textBox = task[property]
          }
        })

        if(editedFinal){
          if (textBox.startsWith('<p>') && textBox.endsWith('</p>')){
            textBox = this.quillText.substring(3,this.quillText.length-4)
          } else {
            textBox = this.quillText
          }

          this.newDescription = textBox;

          this.filteredTasks.filter(function(task){
            if (task.id == idTask){
              task[property] = textBox
            }
          })
        }

        if (document.getElementById(property+"-"+idTask).innerHTML==textBox) {
          textBox = this.escapeHtml(textBox)
        }

        document.getElementById(property+"-"+idTask).innerHTML=textBox

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
      showUserName(task){
        var username
        this.users.filter(function(user){
          if (user.id == task.user_id){
            username = user.name
          }
        })
        return username
      },
      cancelShow(){
        this.showedTask = ''
        this.showedTaskUserName = ''
        this.deleting = false
      },
      showTask(task){
        this.showedTask = task
        var username
        this.users.filter(function(user){
          if (user.id == task.id){
            username = user.name
          }
        })
        this.showedTaskUserName = username
        document.getElementById("show-description").innerHTML = "Description: "+this.showedTask.description
      },
      showTaskToDelete(task){
        this.showTask(task)
        this.deleting = true
      },
      addTask () {
        this.loading = true
        this.creating = true
        if (config.editor == 'medium-editor') {
          console.log(document.getElementById("description").innerHTML)
          this.form.description = document.getElementById("description").innerHTML
        }
        this.form.post(API_TASKS_URL).then(() => {
          var createdId
          var createdName = this.form.name
          var createdDescription = this.form.description
          var createdUserId = this.form.user_id
          crudTask.getAll().then( response => {
            createdId = response.data[response.data.length-1].id
            this.tasks.push({id: createdId ,name: createdName, description: createdDescription, user_id: createdUserId, completed: false})
          })
          this.form.name = ''
          this.form.description = ''
          this.form.user_id = ''
        }).catch((error) => {
          flash(error.message)
        }).then(() => {
          this.creating = false
          this.loading = false
        })
      },
      deleteTask (task) {
        this.loading = true
        this.taskBeingDeleted = task.id
        crudTask.destroy(task.id).then(() => {
          this.tasks.splice(this.tasks.indexOf(task), 1)
        }).catch((error) => {
          flash(error.message)
        }).then(() => {
          this.taskBeingDeleted = null
          this.loading = false
        })
      },
      updateNewTextQuill(text,property) {
        if (property == 'name'){
          this.newName = text
        } else if (property == 'description'){
          this.newDescription = text
        }
      },
      getUpdateIdTask(task,property){
        var idTask = task.id
        if (this.editor=='quill'){
          idTask=this.editedTask
        } else if (this.editor =='medium-editor'){
          var newText = document.getElementById(property+'-'+task.id).innerHTML
          if (property == 'name'){
            this.newName = newText
          } else if (property == 'description'){
            this.newDescription = newText
          }
        }
        return idTask
      },
      updateNameTask (task) {
        this.loading = true
        crudTask.update(task.id, {name: this.newName}).then((response) =>  {
          this.tasks[this.tasks.indexOf(task)].name = this.newName;
          this.newName = ''
          this.editedTask = null
        }).catch((error) => {
          flash(error.message)
        }).then(() => {
          this.loading = false
        })
      },
      updateUserIdTask(task) {
        this.loading = true
        crudTaskUserId.update(task.id, {user_id: this.newUserId }).then((response) =>  {
          this.tasks[this.tasks.indexOf(task)].user_id = this.newUserId;
        }).catch((error) => {
          flash(error.message)
        }).then(() => {
          this.loading = false
        })
      },
      updateDescriptionTask(task) {
        var idTask = this.getUpdateIdTask(task,'description')
        if (this.newDescription.startsWith('<p>') && this.newDescription.endsWith('</p>')){
          this.newDescription = this.newDescription.substring(3,this.newDescription.length-4)
        }
        this.loading = true
        crudTaskDescription.update(idTask, {description: this.newDescription }).catch((error) => {
          flash(error.message)
        }).then(() => {
          this.loading = false
        })
      },
      editTaskName (task) {
        this.editedTask = task
        this.newName = task.name
      },
      editTaskUserId (task) {
        this.editingUserId = task.id
      },
      editTaskDescription(task){
        this.editedTask = task.id
        this.newDescription = task.description
        this.quillText = task.description
      },
      completeTask(task){
        this.loading = true
        crudTaskComplete.store(task.id).then((response) => {
        }).catch((error) => {
          flash(error.message)
        }).then(() => {
          this.loading = false
        })
      },
      incompleteTask(task){
        this.loading = true
        crudTaskComplete.destroy(task.id).then((response) => {
        }).catch((error) => {
          flash(error.message)
        }).then(() => {
          this.loading = false
        }).then(
          this.taskBeingDeleted = null
        )
      },
      fetchTasks(){
        this.loading = true
        crudTask.getAll().then( response => {
          this.tasks = response.data
        }).catch( error => {
          console.log(error)
        }).then(() => {
          this.loading = false
        })
      },
      fetchUsers(){
        this.loading = true
        crudUsers.getAll().then((response) => {
          this.users = response.data
        }).catch((error) => {
          console.log(error)
          flash(error.message)
        }).then(() => {
          this.loading = false
        })
      }
    },
    mounted () {
      this.loading = true
      console.log('loading: '+this.loading)
      new MediumEditor('.editable');
      this.fetchTasks();
      this.fetchUsers();
    }
  }
</script>