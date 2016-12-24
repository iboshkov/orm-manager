<template id="batchControls">
    <div class="panel-block">
        <div class="columns">
            <div class="column">
                <button class="button is-primary is-fullwidth is-outlined">
                        <span class="icon is-small">
                            <i class="fa fa-plus" aria-hidden="true"></i>
                        </span>
                    <span>Add New</span>
                </button>
            </div>
            <div class="column">
                <button class="button is-danger is-fullwidth is-outlined">
                        <span class="icon is-small">
                            <i class="fa fa-warning" aria-hidden="true"></i>
                        </span>
                    <span>Drop All</span>
                </button>
            </div>
        </div>
    </div>
</template>

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
