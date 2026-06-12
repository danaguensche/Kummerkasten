<template>
  <v-container fluid class="mobile-page d-flex justify-center">
    <v-card class="mobile-card mx-auto elevation-4 rounded-lg">
      <div class="card-content pa-4 pa-sm-6 text-center">
        <div class="icon-row mt-2 mb-4" aria-hidden="true">
          <v-icon
            size="40"
            color="indigo-darken-2"
            class="ma-1 mt-8 float-animation"
          >
            mdi-comment-processing-outline
          </v-icon>

          <v-icon
            size="32"
            color="pink-accent-2"
            class="ma-1 float-animation"
          >
            mdi-heart
          </v-icon>

          <v-icon
            size="40"
            color="amber-darken-2"
            class="ma-1 float-animation"
          >
            mdi-lightbulb-on-outline
          </v-icon>
        </div>

        <v-card-title
          class="text-h6 text-indigo-darken-2 font-weight-bold text-center pa-0 mb-2"
        >
          {{ translate.title }}
        </v-card-title>

        <v-card-subtitle
          class="text-body-2 text-center pa-0 mb-5 subtitle-text"
        >
          {{ translate.subtitle }}
        </v-card-subtitle>

        <v-card-actions class="pa-0 action-row">
          <v-btn
            color="indigo-darken-2"
            variant="outlined"
            rounded="pill"
            class="px-4 font-weight-bold flex-grow-1"
            min-height="44"
            @click="router.push('/language')"
          >
            <v-icon class="mr-1" size="small">mdi-arrow-left</v-icon>
            {{ lang.selectedLang === 'de' ? 'Zurück' : 'Back' }}
          </v-btn>

          <v-btn
            color="indigo-darken-2"
            variant="elevated"
            rounded="pill"
            class="px-5 font-weight-bold flex-grow-1"
            min-height="44"
            @click="router.push('/info')"
          >
            {{ translate.next }}
            <v-icon class="ml-1" size="small">mdi-arrow-right</v-icon>
          </v-btn>
        </v-card-actions>
      </div>
    </v-card>
  </v-container>
</template>

<script>
import router from '@/router';

const translations = {
  de: {
    title: 'Dein Kummerkasten',
    subtitle: 'Deine Stimme zählt – teile uns deine\nSorgen mit, anonym und sicher.',
    next: 'Weiter',
  },
  en: {
    title: 'Your Worry Box',
    subtitle: 'Your voice matters – share your\nconcerns with us, anonymous and safe.',
    next: 'Next',
  },
};

export default {
  name: "Header",
  inject: ['lang'],
  data() {
    return { router };
  },
  computed: {
    translate() {
      return translations[this.lang.selectedLang] ?? translations.de;
    },
  },
};
</script>

<style scoped>
.mobile-card {
  width: 100%;
  min-height: 340px;
}

.card-content {
  min-height: 340px;
  display: flex;
  flex-direction: column;
}

.icon-row {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 6px;
}

.subtitle-text {
  white-space: pre-line;
  line-height: 1.5;
}

.action-row {
  display: flex;
  gap: 12px;
  margin-top: auto;
  padding-top: 24px;
}

@keyframes float {
  0%,
  100% {
    transform: translateY(0);
  }
  50% {
    transform: translateY(-8px);
  }
}

.float-animation {
  animation: float 3s ease-in-out infinite;
  animation-delay: calc(var(--delay, 0) * 0.5s);
}

.float-animation:nth-child(1) { --delay: 0; }
.float-animation:nth-child(2) { --delay: 1; }
.float-animation:nth-child(3) { --delay: 2; }

@media (max-width: 420px) {
  .action-row {
    flex-direction: column;
  }
}

@media (prefers-reduced-motion: reduce) {
  .float-animation {
    animation: none;
  }
}
</style>