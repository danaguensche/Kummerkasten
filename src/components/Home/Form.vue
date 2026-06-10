<template>
    <v-container fluid class="pa-4 pa-sm-6 d-flex align-center justify-center" style="min-height: 100vh;">
        <v-card class="mx-auto elevation-4 pa-6 " width="350" rounded="lg">

            <!-- Header -->
            <div class="d-flex align-center ga-2 mb-2">
                <v-card-title class="text-h6 text-indigo-darken-2 font-weight-bold pa-0">
                    {{ t.title }}
                </v-card-title>
            </div>
            <v-divider class="mb-4"></v-divider>

            <v-card-text class="pa-0">
                <v-form ref="form" v-model="valid" @submit.prevent="submitForm">

                    <!-- Geschlecht -->
                    <p class="text-body-2 text-medium-emphasis mb-1">{{ t.gender }} <span class="text-caption">({{
                            t.optional }})</span></p>
                    <v-radio-group v-model="formData.gender" inline hide-details class="mb-4">
                        <v-radio :label="t.female" value="weiblich" color="indigo-darken-2" density="compact"
                            class="mr-2"></v-radio>
                        <v-radio :label="t.male" value="männlich" color="indigo-darken-2" density="compact"
                            class="mr-2"></v-radio>
                        <v-radio :label="t.divers" value="divers" color="indigo-darken-2" density="compact"
                            class="mr-2"></v-radio>
                    </v-radio-group>

                    <!-- Kategorie -->
                    <v-select v-model="formData.category" :items="t.items" :rules="[v => !!v || t.rules.category]"
                        :label="t.categoryLabel" variant="outlined" density="compact" prepend-inner-icon="mdi-tag"
                        class="mb-3" color="indigo-darken-2" required :disabled="loading">
                    </v-select>

                    <!-- Nachricht -->
                    <v-textarea v-model="formData.message" :label="t.messageLabel"
                        :rules="[v => !!v || t.rules.message, v => (v && v.length <= 500) || t.rules.messageMax]"
                        required variant="outlined" density="compact" prepend-inner-icon="mdi-message-text" class="mb-4"
                        color="indigo-darken-2" rows="4" counter="500" auto-grow :disabled="loading">
                    </v-textarea>

                    <!-- Datenschutzhinweis -->
                    <v-sheet color="indigo-lighten-5" rounded="lg" class="pa-3 mb-3">
                        <div class="d-flex align-start ga-2">
                            <v-icon color="indigo-darken-2" size="18"
                                class="mt-1 flex-shrink-0">mdi-shield-lock-outline</v-icon>
                            <p class="text-body-2 text-medium-emphasis ma-0">
                                <strong class="text-indigo-darken-2">{{ t.privacyTitle }}</strong>
                                {{ t.privacyText }}
                            </p>
                        </div>
                    </v-sheet>

                    <v-checkbox v-model="formData.datenschutz" :rules="[v => !!v]" color="indigo-darken-2"
                        density="compact" class="mb-1" :disabled="loading">
                        <template v-slot:label>
                            <span class="text-body-2">{{ t.privacyCheckbox }}</span>
                        </template>
                    </v-checkbox>

                </v-form>
            </v-card-text>

            <!-- Erfolg/Fehler Meldungen -->
            <v-alert v-if="successMessage" type="success" variant="tonal" class="mb-3" closable
                @click:close="successMessage = ''">
                {{ successMessage }}
            </v-alert>
            <v-alert v-if="errorMessage" type="error" variant="tonal" class="mb-3" closable
                @click:close="errorMessage = ''">
                {{ errorMessage }}
            </v-alert>

            <!-- Buttons -->
            <v-card-actions class="pa-0 pt-2">
                <v-btn v-if="!sucess" color="indigo-darken-2" variant="elevated" size="default" rounded="pill"
                    class="px-6 font-weight-bold w-100" :disabled="!valid || loading" :loading="loading"
                    @click="submitForm">
                    <v-icon class="mr-2" size="small">mdi-send</v-icon>
                    {{ t.submit }}
                </v-btn>

                <template v-if="sucess">
                    <v-btn color="indigo-darken-2" variant="outlined" size="default" rounded="pill"
                        class="px-4 font-weight-bold flex-grow-1 mr-2" @click="$router.push('/info')">
                        <v-icon class="mr-1" size="small">mdi-arrow-left</v-icon>
                        {{ t.back }}
                    </v-btn>
                    <v-btn color="indigo-darken-2" variant="elevated" size="default" rounded="pill"
                        class="px-4 font-weight-bold flex-grow-1" @click="$router.push('/qr')">
                        {{ t.next }}
                        <v-icon class="ml-1" size="small">mdi-arrow-right</v-icon>
                    </v-btn>
                </template>
            </v-card-actions>

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
        },
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
        messageLabel: 'Your message',
        privacyTitle: 'Privacy note:',
        privacyText: 'Your message is kept private. It will only be read by staff at this facility. We do not save your personal data or share it with anyone else.',
        privacyCheckbox: 'I have read the privacy note and agree.',
        submit: 'Send',
        back: 'Back',
        next: 'Next',
        items: ['Rules', 'Room/Living', 'Food', 'Staff', 'Something else'],
        rules: {
            category: 'Please choose a topic',
            message: 'Please write a message',
            messageMax: 'Your message can be at most 500 characters long',
        },
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
            sucess: false
        };
    },
    computed: {
        t() {
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

                this.successMessage = this.t.successMsg;
                this.sucess = true;
                this.$refs.form.reset();

            } catch (error) {
                console.error('Fehler:', error);
                this.errorMessage = this.t.errorMsg;
            } finally {
                this.loading = false;
            }
        }
    }
}
</script>