<template>
    <div>
        <nav class="nav">
            <div class="container">
                <div class="nav-left">
                    <a class="nav-item is-brand" href="#">
                        <img src="http://bulma.io/images/bulma-type.png" alt="Bulma logo">
                    </a>
                </div>
                <div class="nav-right">
                    <slot name="header-nav"></slot>
                </div>
            </div>
        </nav>
        <section class="section">
            <div class="container-fluid">
                <div class="columns">
                    <div class="column">
                        <aside class="menu">
                            <p class="menu-label">
                                General
                            </p>
                            <ul class="menu-list">
                                <li><router-link active-class="is-active" :to="{name: 'dashHome'}">Home</router-link></li>
                            </ul>

                            <slot name="sidebar-nav"></slot>
                        </aside>
                        <slot name="sidebar"></slot>
                    </div>
                    <div class="column is-three-quarters">
                        <slot></slot>
                    </div>
                </div>
            </div>
        </section>
        <footer class="footer">
            <div class="container">
                <div class="content has-text-centered">
                    <p>
                        <strong>ORM Manager</strong> by <a href="http://boshkov.tech">Ilija Boshkov</a>. The source code is licensed
                        <a href="http://opensource.org/licenses/mit-license.php">MIT</a>.
                    </p>
                    <p>
                        <a class="icon" href="https://github.com/iboshkov/orm-manager">
                            <i class="fa fa-github"></i>
                        </a>
                    </p>
                    <slot name="footer"></slot>
                </div>
            </div>
        </footer>
    </div>
</template>
<style>
</style>
<script>
    export default{
        data(){
            return{
                msg:'hello vue'
            }
        },
    }
</script>
