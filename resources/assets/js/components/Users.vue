<template>
    <div>
        {{data}}
    </div>
</template>

<style>

</style>

<script>
    export default {
        name: 'name',
        data() {
            return {
                users: []
            }
        },
        mounted() {
            console.log('Mounted ok')
        }
    }
</script>