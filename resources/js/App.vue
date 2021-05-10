<template>
    <div>
    <nav class="navbar navbar-expand-lg navbar-light bg-dark">
        <div class="collapse navbar-collapse">
            <div class="navbar-nav">
                <router-link :to="{name: 'taskList'}" class="nav-item nav-link"> <button type="button" class="btn btn-info text-white"><i class="bi bi-card-list"></i> Task List</button></router-link>
            </div>
        </div>
    </nav>
        <h3 v-if="isMobile()" class="text-center mt-5">Sistemin mobil versiyonu geliştirme aşamasındadır.<br>Lütfen bilgisayarınızdan sisteme giriniz.</h3>
        <router-view v-if="!isMobile()"></router-view>
    </div>
</template>


<script>
export default {
name: "App",
    methods:{

    isMobile(){
        if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
            return true
        }else{
            this.$store.dispatch('taskListAction');
            return false;
        }
    }
    },
}
</script>

<style scoped>

</style>
