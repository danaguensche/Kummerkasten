<template>
    <v-container class="d-flex align-center justify-center" style="min-height: 100vh;">
        <v-card class="mx-auto elevation-4 pa-6" width="350" rounded="lg">
            <div class="text-center mt-3 mb-4">
                <v-icon size="40" color="indigo-darken-2"
                    class="ma-1 float-animation">mdi-comment-processing-outline</v-icon>
                <v-icon size="32" color="pink-accent-2" class="ma-1 float-animation">mdi-heart</v-icon>
                <v-icon size="40" color="amber-darken-2" class="ma-1 float-animation">mdi-lightbulb-on-outline</v-icon>
            </div>

            <v-card-title class="text-h6 text-indigo-darken-2 font-weight-bold text-center pa-2">
                {{ t.title }}
            </v-card-title>

            <v-card-subtitle class="text-body-2 text-center pa-2 mb-4" style="white-space: pre-line;">
                {{ t.subtitle }}
            </v-card-subtitle>

            <v-card-actions class="justify-center pa-2">
                <v-btn color="indigo-darken-2" variant="outlined" size="small" rounded="pill"
                    class="px-4 font-weight-bold mr-2" @click="router.push('/language')">
                    <v-icon class="mr-1" size="small">mdi-arrow-left</v-icon>
                    Zurück
                </v-btn>
                <v-btn color="indigo-darken-2" variant="elevated" size="small" rounded="pill"
                    class="px-5 font-weight-bold" @click="router.push('/info')">
                    <v-icon class="mr-1" size="small">mdi-arrow-right</v-icon>
                    {{ t.next }}
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-container>
</template>

<script>
import router from '@/router';

const translations = {
    de: {
        title:    'Dein Kummerkasten',
        subtitle: 'Deine Stimme zählt – teile uns deine\nSorgen mit, anonym und sicher.',
        next:     'Weiter',
    },
    en: {
        title:    'Your Worry Box',
        subtitle: 'Your voice matters – share your\nconcerns with us, anonymous and safe.',
        next:     'Next',
    },
};

export default {
    name: "Header",
    inject: ['lang'],
    data() {
        return { router };
    },
    computed: {
        t() {
            return translations[this.lang.selectedLang] ?? translations.de;
        },
    },
};
</script>

<style scoped>
@keyframes float {
    0%,
    100% { transform: translateY(0); }
    50%  { transform: translateY(-8px); }
}

.float-animation {
    animation: float 3s ease-in-out infinite;
    animation-delay: calc(var(--delay, 0) * 0.5s);
}

.float-animation:nth-child(1) { --delay: 0; }
.float-animation:nth-child(2) { --delay: 1; }
.float-animation:nth-child(3) { --delay: 2; }
</style>