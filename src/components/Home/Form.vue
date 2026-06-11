<template>
    <v-container fluid class="form-wrapper pa-3 pa-sm-6 d-flex justify-center">
        <v-card class="form-card mx-auto elevation-4 rounded-lg" width="100%" max-width="420">
            <!-- Header -->
            <div class="pa-4 pa-sm-6 pb-2">
                <div class="d-flex align-center ga-2 mb-2">
                    <v-card-title class="text-h6 text-indigo-darken-2 font-weight-bold pa-0">
                        {{ translate.title }}
                    </v-card-title>
                </div>
                <v-divider class="mb-4"></v-divider>
            </div>

            <!-- Scrollbarer Inhalt -->
            <v-card-text class="form-scroll px-4 px-sm-6 pt-0 pb-2 overflow-y-auto">
                <v-form ref="form" v-model="valid" @submit.prevent="submitForm">
                    <p class="text-body-2 text-medium-emphasis mb-1">
                        {{ translate.gender }}
                        <span class="text-caption">({{ translate.optional }})</span>
                    </p>

                    <v-radio-group v-model="formData.gender" inline hide-details class="mb-4">
                        <v-radio :label="translate.female" value="weiblich" color="indigo-darken-2" density="compact"
                            class="mr-2" />
                        <v-radio :label="translate.male" value="männlich" color="indigo-darken-2" density="compact"
                            class="mr-2" />
                        <v-radio :label="translate.divers" value="divers" color="indigo-darken-2" density="compact"
                            class="mr-2" />
                    </v-radio-group>

                    <v-select v-model="formData.category" :items="translate.items"
                        :rules="[v => !!v || translate.rules.category]" :label="translate.categoryLabel"
                        variant="outlined" density="compact" prepend-inner-icon="mdi-tag" class="mb-3"
                        color="indigo-darken-2" required :disabled="loading" />

                    <v-select v-model="formData.building" :items="translate.buildings"
                        :rules="[v => !!v || translate.rules.building]" :label="translate.buildingLabel"
                        variant="outlined" density="compact" prepend-inner-icon="mdi-home-modern" class="mb-3"
                        color="indigo-darken-2" required :disabled="loading" />

                    <v-select v-if="formData.building === 'Haus Ponte'" v-model="formData.group"
                        :items="translate.groups_hausPonte" :rules="[v => !!v || translate.rules.building]"
                        :label="translate.groupLabel" variant="outlined" density="compact"
                        prepend-inner-icon="mdi-account-group" class="mb-3" color="indigo-darken-2" required
                        :disabled="loading" />

                    <v-select v-else-if="formData.building === 'Diakonie am Park'" v-model="formData.group"
                        :items="translate.groups_diakonieAmPark" :rules="[v => !!v || translate.rules.building]"
                        :label="translate.groupLabel" variant="outlined" density="compact"
                        prepend-inner-icon="mdi-account-group" class="mb-3" color="indigo-darken-2" required
                        :disabled="loading" />

                    <v-textarea v-model="formData.message" :label="translate.messageLabel" :rules="[
                        v => !!v || translate.rules.message,
                        v => (v && v.length <= 500) || translate.rules.messageMax
                    ]" required variant="outlined" density="compact" prepend-inner-icon="mdi-message-text" class="mb-4"
                        color="indigo-darken-2" rows="4" counter="500" auto-grow :disabled="loading" />

                    <v-sheet color="indigo-lighten-5" rounded="lg" class="pa-3 mb-3">
                        <div class="d-flex align-start ga-2">
                            <v-icon color="indigo-darken-2" size="18" class="mt-1 flex-shrink-0">
                                mdi-shield-lock-outline
                            </v-icon>
                            <p class="text-body-2 text-medium-emphasis ma-0">
                                <strong class="text-indigo-darken-2">{{ translate.privacyTitle }}</strong>
                                {{ translate.privacyText }}
                            </p>
                        </div>
                    </v-sheet>

                    <v-checkbox v-model="formData.datenschutz" :rules="[v => !!v]" color="indigo-darken-2"
                        density="compact" class="mb-2" :disabled="loading">
                        <template v-slot:label>
                            <span class="text-body-2">{{ translate.privacyCheckbox }}</span>
                        </template>
                    </v-checkbox>
                </v-form>
            </v-card-text>

            <!-- Feste Footer-Actions -->
            <div class="pa-4 pa-sm-6 pt-2">
                <v-alert v-if="successMessage" type="success" variant="tonal" class="mb-3" closable
                    @click:close="successMessage = ''">
                    {{ successMessage }}
                </v-alert>

                <v-alert v-if="errorMessage" type="error" variant="tonal" class="mb-3" closable
                    @click:close="errorMessage = ''">
                    {{ errorMessage }}
                </v-alert>

                <v-card-actions class="pa-0 mobile-actions">
                    <v-btn v-if="!sucess" color="indigo-darken-2" variant="elevated" rounded="pill"
                        class="px-6 font-weight-bold w-100" :disabled="!valid || loading" :loading="loading"
                        @click="submitForm">
                        <v-icon class="mr-2" size="small">mdi-send</v-icon>
                        {{ translate.submit }}
                    </v-btn>

                    <template v-if="sucess">
                        <v-btn color="indigo-darken-2" variant="outlined" rounded="pill"
                            class="px-4 font-weight-bold flex-grow-1 mr-2" @click="$router.push('/info')">
                            <v-icon class="mr-1" size="small">mdi-arrow-left</v-icon>
                            {{ translate.back }}
                        </v-btn>

                        <v-btn color="indigo-darken-2" variant="elevated" rounded="pill"
                            class="px-4 font-weight-bold flex-grow-1" @click="$router.push('/qr')">
                            {{ translate.next }}
                            <v-icon class="ml-1" size="small">mdi-arrow-right</v-icon>
                        </v-btn>
                    </template>
                </v-card-actions>
            </div>
        </v-card>
    </v-container>
</template>

<script>
const translations = {
    de: {
        title: 'Dein Anliegen',
        gender: 'Dein Geschlecht',
        optional: 'optional',
        female: 'Weiblich',
        male: 'Männlich',
        divers: 'Divers',
        categoryLabel: 'Kategorie',
        buildingLabel: 'Gebäude',
        messageLabel: 'Deine Nachricht',
        privacyTitle: 'Datenschutzhinweis:',
        privacyText: 'Deine Nachricht wird vertraulich behandelt und ausschließlich intern per E-Mail weitergeleitet. Es werden keine personenbezogenen Daten gespeichert oder an Dritte weitergegeben.',
        privacyCheckbox: 'Ich habe den Datenschutzhinweis gelesen und stimme zu.',
        submit: 'Absenden',
        back: 'Zurück',
        next: 'Weiter',
        items: ['Regeln', 'Zimmer/Unterkunft', 'Essen', 'Betreuer/Personal', 'Sonstiges'],
        rules: {
            category: 'Kategorie ist erforderlich',
            message: 'Nachricht ist erforderlich',
            messageMax: 'Nachricht darf maximal 500 Zeichen lang sein',
            building: 'Bitte wähle ein Gebäude aus',
        },
        buildings: [
            'Diakonie am Park',
            'Haus Ponte',
            'AWG Röntgenstraße Hof',
            'AWG M8 Naila',
            'AWG Plauen'
        ],
        groupLabel: 'Gruppe',
        groups_hausPonte: [
            'Ponte 3/Stock 3',
            'Ponte 2/Stock 2',
            'MUVAKI Appartement/Stock 2',
            'Ponte 1/Stock 1',
            'Betreutes Wohnen U18/Erdgeschoss',
        ],
        groups_diakonieAmPark: [
            'Diakonie am Park Stock 4',
            'Diakonie am Park Stock 3',
        ],
        successMsg: 'Deine Nachricht wurde erfolgreich gesendet! Vielen Dank für dein Vertrauen.',
        errorMsg: 'Fehler beim Senden der Nachricht. Bitte versuche es später erneut.',
    },
    en: {
        title: 'Share your concern',
        gender: 'Your gender',
        optional: 'optional',
        female: 'Female',
        male: 'Male',
        divers: 'Other',
        categoryLabel: 'Topic',
        buildingLabel: 'Building',
        messageLabel: 'Your message',
        privacyTitle: 'Privacy note:',
        privacyText: 'Your message is kept private. It will only be read by staff at this facility. We do not save your personal data or share it with anyone else.',
        privacyCheckbox: 'I have read the privacy note and agree.',
        submit: 'Submit',
        back: 'Back',
        next: 'Next',
        items: ['Rules', 'Room/Living', 'Food', 'Staff', 'Something else'],
        rules: {
            category: 'Please choose a topic',
            message: 'Please write a message',
            messageMax: 'Your message can be at most 500 characters long',
            building: 'Please choose a building',
        },
        buildings: [
            'Diakonie am Park',
            'Haus Ponte',
            'AWG Röntgenstraße Hof',
            'AWG M8 Naila',
            'AWG Plauen'
        ],
        groupLabel: 'Group',
        groups_hausPonte: [
            'Ponte 3/Stock 3',
            'Ponte 2/Stock 2',
            'MUVAKI Appartement/Stock 2',
            'Ponte 1/Stock 1',
            'Betreutes Wohnen U18/Erdgeschoss',
        ],
        groups_diakonieAmPark: [
            'Diakonie am Park Stock 4',
            'Diakonie am Park Stock 3',
        ],
        successMsg: 'Your message was sent. Thank you for telling us!',
        errorMsg: 'Something went wrong. Please try again later.',
    },
};

export default {
    name: 'Form',
    inject: ['lang'],
    data() {
        return {
            valid: false,
            loading: false,
            successMessage: '',
            errorMessage: '',
            formData: {
                gender: '',
                category: '',
                message: '',
                datenschutz: false
            },
            sucess: false,

            buildings: [
                { label: 'Diakonie am Park', value: 'Diakonie am Park' },
                { label: 'Haus Ponte', value: 'Haus Ponte' },
                { label: 'AWG Röntgenstraße Hof', value: 'AWG Röntgenstraße Hof' },
                { label: 'AWG M8 Naila', value: 'AWG M8 Naila' },
                { label: 'AWG Plauen', value: 'AWG Plauen' },],

            groups_hausPonte: [
                { label: 'Ponte 3/Stock 3', value: 'Ponte 3/Stock 3' },
                { label: 'Ponte 2/Stock 2', value: 'Ponte 2/Stock 2' },
                { label: 'MUVAKI Appartement/Stock 2', value: 'MUVAKI Appartement/Stock 2' },
                { label: 'Ponte 1/Stock 1', value: 'Ponte 1/Stock 1' },
                { label: 'Betreutes Wohnen U18/Erdgeschoss', value: 'Betreutes Wohnen U18/Erdgeschoss' },
            ],

            groups_diakonieAmPark: [
                { label: 'Diakonie am Park Stock 4', value: 'Diakonie am Park Stock 4' },
                { label: 'Diakonie am Park Stock 3', value: 'Diakonie am Park Stock 3' },
            ],

        };
    },
    computed: {
        translate() {
            return translations[this.lang.selectedLang] ?? translations.de;
        },
    },
    methods: {
        async submitForm() {
            const { valid } = await this.$refs.form.validate();
            if (!valid) return;

            this.loading = true;
            this.errorMessage = '';
            this.successMessage = '';

            try {
                const payload = {
                    gender: this.formData.gender || 'Keine Angabe',
                    category: this.formData.category,
                    message: this.formData.message,
                    date: new Date().toLocaleDateString('de-DE'),
                    time: new Date().toLocaleTimeString('de-DE')
                };

                const response = await fetch('phpmails/mail.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(payload)
                });

                const result = await response.json();

                if (!response.ok || result.error) {
                    throw new Error(result.error || 'Unbekannter Fehler');
                }

                this.successMessage = this.translate.successMsg;
                this.sucess = true;
                this.$refs.form.reset();

            } catch (error) {
                console.error('Fehler:', error);
                this.errorMessage = this.translate.errorMsg;
            } finally {
                this.loading = false;
            }
        }
    }
}
</script>

<style scoped>
.form-wrapper {
  min-height: 100dvh;
  align-items: flex-start;
  padding-top: 16px;
  padding-bottom: 16px;
}

.form-card {
  width: 100%;
  max-width: 420px;
  max-height: calc(100dvh - 32px);
  display: flex;
  flex-direction: column;
}

.form-scroll {
  flex: 1 1 auto;
  min-height: 0;
}

@media (max-width: 600px) {
  .form-wrapper {
    padding: 12px;
  }

  .form-card {
    max-height: calc(100dvh - 24px);
    border-radius: 16px;
  }
}
</style>