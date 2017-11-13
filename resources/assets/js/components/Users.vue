<template>
    <div>
        Users ({{numUsers}}):
        <select>
            <option :value="user.id" v-for="user in users">{{user.name}} - {{user.email}}</option>
        </select>
    </div>
</template>

<style>

</style>

<script>
  import axios from 'axios'

  export default {
    name: 'name',
    data () {
      return {
        users: []
      }
    },
    computed: {
      numUsers () {
        return this.users.length
      }
    },
    mounted () {
      console.log('Mounted ok')

      //Promises
      axios.get('/api/v1/users').then(response => {
        this.users = response.data
      }).catch(error => {
        console.log(error)

      })
    }
  }
</script>