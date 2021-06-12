<template>
    <div v-if="showAlert" class="alert alert-success position-fixed bottom-0 end-0" role="alert">
        {{ message }}
    </div>
</template>

<script>
export default {
    props: ['message'],
    data() {
        return {
            showAlert: false
        }
    },
    mounted() {
        if (this.message) {
            this.showAlert = true
            setTimeout(() => {
                this.showAlert = false
            }, 3000);
        }
    }
}
</script>

<style scoped>

</style>
