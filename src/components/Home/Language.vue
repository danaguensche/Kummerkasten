<template>
    <v-container class="d-flex align-center justify-center" style="min-height: 100vh;">
        <v-card class="mx-auto elevation-4 pa-6" max-width="500" rounded="lg">
            <v-card-title v-if="selectedLang == 'de'" class="text-h6 text-indigo-darken-2 font-weight-bold pa-0 mb-2">
                Wähle deine Sprache aus
            </v-card-title>
            <v-card-title v-else class="text-h6 text-indigo-darken-2 font-weight-bold pa-0 mb-2">
                Choose your language </v-card-title>
            <v-divider class="mb-4"></v-divider>

            <v-card-text class="pa-0 mb-4">
                <div class="d-flex justify-center ga-6">

                    <!-- Deutsch -->
                    <div class="d-flex flex-column align-center pa-2 rounded-lg cursor-pointer" :class="selectedLang === 'de'
                        ? 'border-md border-indigo-darken-2 bg-indigo-lighten-5'
                        : 'border border-transparent'" @click="selectedLang = 'de'">
                        <!-- Deutsch -->
                        <v-badge :model-value="selectedLang === 'de'" icon="mdi-check-circle" color="success"
                            location="top end">
                            <v-avatar size="72">
                                <v-img :src="german" alt="Deutsch" cover />
                            </v-avatar>
                        </v-badge>
                        <span class="text-caption font-weight-medium mt-1">Deutsch</span>
                    </div>

                    <!-- Englisch -->
                    <div class="d-flex flex-column align-center pa-2 rounded-lg cursor-pointer" :class="selectedLang === 'en'
                        ? 'border-md border-indigo-darken-2 bg-indigo-lighten-5'
                        : 'border border-transparent'" @click="selectedLang = 'en'">
                        <!-- Englisch -->
                        <v-badge :model-value="selectedLang === 'en'" icon="mdi-check-circle" color="success"
                            location="top end">
                            <v-avatar size="72">
                                <v-img :src="english" alt="English" cover />
                            </v-avatar>
                        </v-badge>
                        <span class="text-caption font-weight-medium mt-1">English</span>
                    </div>

                </div>
            </v-card-text>

            <v-card-actions class="pa-0 pt-2">

                <v-btn v-if="selectedLang == 'de'" color="indigo-darken-2" variant="elevated" size="small" rounded="pill"
                    class="px-4 font-weight-bold flex-grow-1" :disabled="!selectedLang" @click="router.push('/info')">
                    Weiter
                    <v-icon class="ml-1" size="small">mdi-arrow-right</v-icon>
                </v-btn>

                <v-btn v-else color="indigo-darken-2" variant="elevated" size="small" rounded="pill"
                    class="px-4 font-weight-bold flex-grow-1" :disabled="!selectedLang" @click="router.push('/info')">
                    Continue
                    <v-icon class="ml-1" size="small">mdi-arrow-right</v-icon>
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-container>
</template>

<script>
export default {
    name: "LanguageSelect",
    inject: ['lang'],
    data() {
        return {
            router: this.$router,
            german: '/img/deutschland.png',
            english: '/img/england.png',
        };
    },
    computed: {
        selectedLang: {
            get() { return this.lang.selectedLang; },
            set(val) { this.lang.selectedLang = val; },
        },
    },
};
</script>