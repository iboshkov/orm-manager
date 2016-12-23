<template>
    <transition name="fade">
        <div>
            <app-layout>
                This is the dash
            </app-layout>
        </div>
    </transition>
</template>
<style>

</style>
<script>
    import AppLayout from './App.vue'
    export default{
        data(){
            return{
                msg:'hello vue'
            }
        },
        components:{
            AppLayout,
        }
    }
</script>
