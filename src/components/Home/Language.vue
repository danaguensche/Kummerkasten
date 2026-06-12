<template>
<v-container fluid class="mobile-page d-flex justify-center">
    <v-card class="mobile-card mx-auto elevation-4 rounded-lg">
        <div class="card-content pa-4 pa-sm-6 text-center">
            <v-card-title v-if="selectedLang == 'de'"
                    class="text-h6 text-indigo-darken-2 font-weight-bold pa-0 mb-2">
                    Wähle deine Sprache aus
                </v-card-title>

                <v-card-title v-else class="text-h6 text-indigo-darken-2 font-weight-bold pa-0 mb-2">
                    Choose your language
                </v-card-title>

                <v-divider class="mb-4"></v-divider>

                <v-card-text class="pa-0 mb-4">
                    <div class="language-options">
                        <!-- Deutsch -->
                        <button type="button" class="language-option" :class="selectedLang === 'de'
                            ? 'language-option--active'
                            : 'language-option--inactive'" @click="selectedLang = 'de'">
                            <v-badge :model-value="selectedLang === 'de'" icon="mdi-check-circle" color="success"
                                location="top end">
                                <v-avatar size="72">
                                    <v-img :src="german" alt="Deutsch" cover />
                                </v-avatar>
                            </v-badge>
                            <span class="text-caption font-weight-medium mt-2">Deutsch</span>
                        </button>

                        <!-- Englisch -->
                        <button type="button" class="language-option" :class="selectedLang === 'en'
                            ? 'language-option--active'
                            : 'language-option--inactive'" @click="selectedLang = 'en'">
                            <v-badge :model-value="selectedLang === 'en'" icon="mdi-check-circle" color="success"
                                location="top end">
                                <v-avatar size="72">
                                    <v-img :src="english" alt="English" cover />
                                </v-avatar>
                            </v-badge>
                            <span class="text-caption font-weight-medium mt-2">English</span>
                        </button>
                    </div>
                </v-card-text>

                <v-card-actions class="pa-0 mobile-actions">
                    <v-btn color="indigo-darken-2" variant="elevated" rounded="pill" class="font-weight-bold w-100"
                        min-height="44" :disabled="!selectedLang" @click="router.push('/home')">
                        {{ selectedLang == 'de' ? 'Weiter' : 'Continue' }}
                        <v-icon class="ml-1" size="small">mdi-arrow-right</v-icon>
                    </v-btn>
                </v-card-actions>
            </div>
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

<style scoped>
.language-card {
  width: 100%;
  min-height: 340px;
}

.card-content {
  min-height: 340px;
  display: flex;
  flex-direction: column;
}


.language-options {
    margin-top: 20px;
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 16px;
}

.language-option {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    min-height: 132px;
    padding: 12px;
    border-radius: 16px;
    border: 1px solid transparent;
    background: transparent;
    cursor: pointer;
    transition: all 0.2s ease;
}

.language-option--active {
    border: 2px solid rgb(var(--v-theme-indigo-darken-2));
    background: rgb(var(--v-theme-indigo-lighten-5));
}

.language-option--inactive {
    border: 1px solid transparent;
}

@media (max-width: 400px) {
    .language-wrapper {
        padding: 12px;
        align-items: flex-start;
    }

    .language-card {
        margin-top: 16px;
    }

    .language-options {
        gap: 12px;
    }

    .language-option {
        min-height: 120px;
        padding: 10px;
    }
}
</style>