<template>
    <v-container class="d-flex align-center justify-center" style="min-height: 100vh;">
        <v-card class="mx-auto elevation-4 pa-6" max-width="500" rounded="lg">
            <v-card-title class="text-h6 text-indigo-darken-2 font-weight-bold mb-2 pa-0" primary-title>
                Dein Anliegen
            </v-card-title>
            <v-divider class="mb-3"></v-divider>


            <v-card-text class="pa-0">
                <v-form ref="form" v-model="valid" @submit.prevent="submitForm">
                    <v-text-field v-model="formData.firstname" label="Vorname (optional)" variant="outlined"
                        density="compact" prepend-inner-icon="mdi-account" class="mb-3" color="indigo-darken-2"
                        :disabled="loading">
                    </v-text-field>

                    <v-text-field v-model="formData.lastname" label="Nachname (optional)" variant="outlined"
                        density="compact" prepend-inner-icon="mdi-account" class="mb-3" color="indigo-darken-2"
                        :disabled="loading">
                    </v-text-field>

                    <v-select v-model="formData.category" :items="items" :rules="selectRules" label="Kategorie"
                        variant="outlined" density="compact" prepend-inner-icon="mdi-tag" class="mb-3"
                        color="indigo-darken-2" required :disabled="loading">
                    </v-select>

                    <v-textarea v-model="formData.message" label="Deine Nachricht" :rules="messageRules" required
                        variant="outlined" density="compact" prepend-inner-icon="mdi-message-text" class="mb-3"
                        color="indigo-darken-2" rows="3" counter="500" auto-grow :disabled="loading">
                    </v-textarea>
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

            <v-card-actions class="pa-0 pt-2">
                <v-checkbox v-if="!sucess" v-model="formData.anonymous" label="Anonym bleiben" color="indigo-darken-2"
                    density="compact" class="flex-grow-0" :disabled="loading">
                </v-checkbox>

                <v-spacer></v-spacer>

                <v-btn v-if="!sucess" color="indigo-darken-2" variant="elevated" size="small" rounded="pill"
                    class="px-4 font-weight-bold" :disabled="!valid || loading" :loading="loading" @click="submitForm">
                    <v-icon class="mr-1" size="small">mdi-send</v-icon>
                    Absenden
                </v-btn>

                <v-btn v-if="sucess" color="indigo-darken-2" variant="outlined" size="small" rounded="pill"
                    class="px-4 font-weight-bold flex-grow-1 mr-2" @click="router.push('/info')">
                    <v-icon class="mr-1" size="small">mdi-arrow-left</v-icon>
                    Zurück
                </v-btn>
                <v-btn v-if="sucess" color="indigo-darken-2" variant="elevated" size="small" rounded="pill"
                    class="px-4 font-weight-bold flex-grow-1" @click="router.push('/qr')">
                    Weiter
                    <v-icon class="ml-1" size="small">mdi-arrow-right</v-icon>
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-container>
</template>

<script>
import router from '@/router';
import emailjs from 'emailjs-com';

export default {
    name: 'Form',
    data() {
        return {
            router: this.$router,
            valid: false,
            loading: false,
            successMessage: '',
            errorMessage: '',
            formData: {
                firstname: '',
                lastname: '',
                category: '',
                message: '',
                anonymous: false
            },
            messageRules: [
                v => !!v || 'Nachricht ist erforderlich',
                v => (v && v.length <= 500) || 'Nachricht darf maximal 500 Zeichen lang sein'
            ],
            selectRules: [
                v => !!v || 'Kategorie ist erforderlich'
            ],
            items: ['Regeln', 'Zimmer/Unterkunft', 'Essen', 'Betreuer/Personal', 'Sonstiges'],
            select: null,
            sucess: false
        };
    },
    methods: {
        async submitForm() {
            if (this.$refs.form.validate()) {
                this.loading = true;
                this.errorMessage = '';
                this.successMessage = '';

                if (this.formData.anonymous) {
                    this.formData.anonymous = 'Ja';
                    this.formData.firstname = 'Anonym';
                    this.formData.lastname = 'Anonym';
                } else {
                    this.formData.anonymous = 'Nein';
                }

                try {
                    // EmailJS Template Variablen
                    const templateParams = {
                        from_name: this.formData.anonymous ? 'Anonym' : `${this.formData.firstname} ${this.formData.lastname}`.trim() || 'Unbekannt',
                        firstname: this.formData.firstname || 'Nicht angegeben',
                        lastname: this.formData.lastname || 'Nicht angegeben',
                        category: this.formData.category,
                        message: this.formData.message,
                        anonymous: this.formData.anonymous,
                        date: new Date().toLocaleDateString('de-DE'),
                        time: new Date().toLocaleTimeString('de-DE')
                    };

                    // E-Mail über EmailJS senden
                    await emailjs.send(
                        'service_7u6xfpo',      //Service ID
                        'template_n9tvcd7',     //Template ID
                        templateParams,
                        'mhUHetv55RImbj_Mv'          //user ID
                    );

                    // Erfolgsmeldung
                    this.successMessage = 'Deine Nachricht wurde erfolgreich gesendet! Vielen Dank für dein Vertrauen.';
                    this.sucess = true;

                    // Formular zurücksetzen
                    this.$refs.form.reset();
                    this.select = null;

                } catch (error) {
                    console.error('EmailJS Fehler:', error);
                    this.errorMessage = 'Fehler beim Senden der Nachricht. Bitte versuche es später erneut.';
                } finally {
                    this.loading = false;
                }
            }
        }
    }
}
</script>