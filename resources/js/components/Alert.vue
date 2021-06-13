<template>
    <div v-if="showAlert"
         class="alert alert-success position-fixed bottom-0 end-0"
         :class="{'alert-success': type === 'success', 'alert-danger': type === 'denied'}"
         role="alert"
    >
        {{ message }}
    </div>
</template>

<script>
export default {
    props: ['message', 'type'],
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
