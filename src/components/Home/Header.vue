<template>
    <v-container class="d-flex align-center justify-center" style="min-height: 100vh;">
        <v-card class="mx-auto elevation-4 pa-12 mt-6" max-width="650" rounded="lg">
            <div class="text-center mt-6 mb-4">
                <v-icon size="50" color="indigo-darken-2" class="ma-2 float-animation">mdi-comment-processing-outline</v-icon>
                <v-icon size="40" color="pink-accent-2" class="ma-2 float-animation">mdi-heart</v-icon>
                <v-icon size="50" color="amber-darken-2" class="ma-2 float-animation">mdi-lightbulb-on-outline</v-icon>
            </div>
            
            <v-card-title class="text-h5 text-indigo-darken-2 font-weight-bold text-center pa-4">
                Dein Kummerkasten
            </v-card-title>
            
            <v-card-subtitle class="text-h8 text-center pa-4 mb-6">
                Deine Stimme zählt - teile uns deine Sorgen mit
            </v-card-subtitle>
            
            <v-card-actions class="justify-center pa-6">
                <v-btn
                    color="indigo-darken-2"
                    variant="elevated"
                    size="small"
                    rounded="pill"
                    class="px-5 font-weight-bold elevation-8"
                    @click="router.push('/info')">
                    Weiter
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-container>
</template>

<script>
import router from '@/router';
export default {
    name: "Header",
    data() {
        return {
            router
        }
    }
}
</script>

<style scoped>
@keyframes float {
    0%, 100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-10px);
    }
}

.float-animation {
    animation: float 3s ease-in-out infinite;
}
</style>