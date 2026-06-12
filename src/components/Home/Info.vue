<template>
  <v-container fluid class="mobile-page d-flex justify-center">
    <v-card class="mobile-card mx-auto elevation-4 rounded-lg">
      <div class="card-content pa-4 pa-sm-6 text-center">
        <v-card-title class="text-h6 text-indigo-darken-2 font-weight-bold pa-0 mb-2 text-left ml-5" primary-title>
          {{ translate.title }}
        </v-card-title>

        <v-divider class="mb-3"></v-divider>

        <v-card-text class="info-content pa-0">
          <v-list lines="one" density="comfortable" class="pa-0 ml-4 bg-transparent ">
            <v-list-item v-for="item in translate.listItems" :key="item" class="px-0 mb-2 rounded-lg mr-8 text-left" min-height="48">
              <template v-slot:prepend>
                <v-icon icon="mdi-check-circle" color="success" size="small" class="mr-3" />
              </template>

              <v-list-item-title class="text-body-2" style="white-space: pre-line; line-height: 1.4;">
                {{ item }}
              </v-list-item-title>
            </v-list-item>
          </v-list>
        </v-card-text>

        <v-card-actions class="pa-0 mobile-actions">
          <v-btn color="indigo-darken-2" variant="outlined" rounded="pill" class="px-4 font-weight-bold flex-grow-1"
            min-height="44" @click="router.push('/language')">
            <v-icon class="mr-1" size="small">mdi-arrow-left</v-icon>
            {{ translate.back }}
          </v-btn>

          <v-btn color="indigo-darken-2" variant="elevated" rounded="pill" class="px-4 font-weight-bold flex-grow-1"
            min-height="44" @click="router.push('/form')">
            {{ translate.next }}
            <v-icon class="ml-1" size="small">mdi-arrow-right</v-icon>
          </v-btn>
        </v-card-actions>
      </div>
    </v-card>
  </v-container>
</template>

<script>
const translations = {
  de: {
    title: 'Wie funktioniert\'s?',
    back: 'Zurück',
    next: 'Weiter',
    listItems: [
      'Fülle das Formular aus',
      'Klicke auf Absenden',
      'Deine Nachricht ist anonym',
    ],
  },
  en: {
    title: 'How does it work?',
    back: 'Back',
    next: 'Next',
    listItems: [
      'Fill out the form',
      'Click on Submit',
      'Your message is anonymous',
    ],
  },
};

export default {
  name: "Info",
  inject: ['lang'],
  data() {
    return {
      router: this.$router,
    };
  },
  computed: {
    translate() {
      return translations[this.lang.selectedLang] ?? translations.de;
    },
  },
};
</script>

<style scoped>
.info-card {
  width: 100%;
  min-height: 340px;
}

.card-content {
  min-height: 340px;
  display: flex;
  flex-direction: column;
}

.action-row {
  display: flex;
  gap: 12px;
  margin-top: auto;
  padding-top: 24px;
}


</style>