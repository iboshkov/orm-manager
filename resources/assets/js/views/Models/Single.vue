<template>
        <div>
            <model-component :class-name="$route.params.id" />
            <div id="demo">
                <button v-on:click="show = !show">
                    Toggle
                </button>
            </div>
        </div>
</template>
<style>
    body{
        background-color:#ff0000;
    }
</style>
<script>
    export default{
        data(){
            return{
                msg:'hello vue'
            }
        },
        components:{
        }
    }
</script>
