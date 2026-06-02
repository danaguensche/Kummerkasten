<template>
    <v-container fluid class="pa-4 pa-sm-6 d-flex align-center justify-center" style="min-height: 100vh;">
        <v-card
            class="mx-auto w-100 elevation-4 pa-4 pa-sm-6"
            style="max-width: 520px;"
            rounded="lg">

            <!-- Header -->
            <div class="d-flex align-center ga-2 mb-2">
                <v-card-title class="text-h6 text-indigo-darken-2 font-weight-bold pa-0">
                    Dein Anliegen
                </v-card-title>
            </div>
            <v-divider class="mb-4"></v-divider>

            <v-card-text class="pa-0">
                <v-form ref="form" v-model="valid" @submit.prevent="submitForm">

                    <!-- Geschlecht: horizontal auf allen Bildschirmgrößen -->
                    <p class="text-body-2 text-medium-emphasis mb-1">Dein Geschlecht <span class="text-caption">(optional)</span></p>
                    <v-radio-group v-model="formData.gender" inline hide-details class="mb-4">
                        <v-radio label="Weiblich" value="weiblich" color="indigo-darken-2" density="compact" class="mr-2"></v-radio>
                        <v-radio label="Männlich" value="männlich" color="indigo-darken-2" density="compact" class="mr-2"></v-radio>
                        <v-radio label="Divers"   value="divers"   color="indigo-darken-2" density="compact" class="mr-2"></v-radio>
                    </v-radio-group>

                    <!-- Kategorie -->
                    <v-select
                        v-model="formData.category"
                        :items="items"
                        :rules="selectRules"
                        label="Kategorie"
                        variant="outlined"
                        density="compact"
                        prepend-inner-icon="mdi-tag"
                        class="mb-3"
                        color="indigo-darken-2"
                        required
                        :disabled="loading">
                    </v-select>

                    <!-- Nachricht -->
                    <v-textarea
                        v-model="formData.message"
                        label="Deine Nachricht"
                        :rules="messageRules"
                        required
                        variant="outlined"
                        density="compact"
                        prepend-inner-icon="mdi-message-text"
                        class="mb-4"
                        color="indigo-darken-2"
                        rows="4"
                        counter="500"
                        auto-grow
                        :disabled="loading">
                    </v-textarea>

                    <!-- Datenschutzhinweis -->
                    <v-sheet color="indigo-lighten-5" rounded="lg" class="pa-3 mb-3">
                        <div class="d-flex align-start ga-2">
                            <v-icon color="indigo-darken-2" size="18" class="mt-1 flex-shrink-0">mdi-shield-lock-outline</v-icon>
                            <p class="text-body-2 text-medium-emphasis ma-0">
                                <strong class="text-indigo-darken-2">Datenschutzhinweis:</strong>
                                Deine Nachricht wird vertraulich behandelt und ausschließlich intern per E-Mail
                                weitergeleitet. Es werden keine personenbezogenen Daten gespeichert oder an Dritte
                                weitergegeben.
                            </p>
                        </div>
                    </v-sheet>

                    <v-checkbox
                        v-model="formData.datenschutz"
                        :rules="datenschutzRules"
                        color="indigo-darken-2"
                        density="compact"
                        class="mb-1"
                        :disabled="loading">
                        <template v-slot:label>
                            <span class="text-body-2">
                                Ich habe den Datenschutzhinweis gelesen und stimme zu.
                            </span>
                        </template>
                    </v-checkbox>

                </v-form>
            </v-card-text>

            <!-- Erfolg/Fehler Meldungen -->
            <v-alert
                v-if="successMessage"
                type="success"
                variant="tonal"
                class="mb-3"
                closable
                @click:close="successMessage = ''">
                {{ successMessage }}
            </v-alert>

            <v-alert
                v-if="errorMessage"
                type="error"
                variant="tonal"
                class="mb-3"
                closable
                @click:close="errorMessage = ''">
                {{ errorMessage }}
            </v-alert>

            <!-- Buttons -->
            <v-card-actions class="pa-0 pt-2">
                <!-- Vor dem Absenden -->
                <v-btn
                    v-if="!sucess"
                    color="indigo-darken-2"
                    variant="elevated"
                    size="default"
                    rounded="pill"
                    class="px-6 font-weight-bold w-100"
                    :disabled="!valid || loading"
                    :loading="loading"
                    @click="submitForm">
                    <v-icon class="mr-2" size="small">mdi-send</v-icon>
                    Absenden
                </v-btn>

                <!-- Nach erfolgreichem Absenden -->
                <template v-if="sucess">
                    <v-btn
                        color="indigo-darken-2"
                        variant="outlined"
                        size="default"
                        rounded="pill"
                        class="px-4 font-weight-bold flex-grow-1 mr-2"
                        @click="$router.push('/info')">
                        <v-icon class="mr-1" size="small">mdi-arrow-left</v-icon>
                        Zurück
                    </v-btn>
                    <v-btn
                        color="indigo-darken-2"
                        variant="elevated"
                        size="default"
                        rounded="pill"
                        class="px-4 font-weight-bold flex-grow-1"
                        @click="$router.push('/qr')">
                        Weiter
                        <v-icon class="ml-1" size="small">mdi-arrow-right</v-icon>
                    </v-btn>
                </template>
            </v-card-actions>

        </v-card>
    </v-container>
</template>

<script>
export default {
    name: 'Form',
    data() {
        return {
            valid: false,
            loading: false,
            successMessage: '',
            errorMessage: '',
            formData: {
                gender:      '',
                category:    '',
                message:     '',
                datenschutz: false
            },
            messageRules: [
                v => !!v || 'Nachricht ist erforderlich',
                v => (v && v.length <= 500) || 'Nachricht darf maximal 500 Zeichen lang sein'
            ],
            selectRules: [
                v => !!v || 'Kategorie ist erforderlich'
            ],
            datenschutzRules: [
                v => !!v 
            ],
            items: ['Regeln', 'Zimmer/Unterkunft', 'Essen', 'Betreuer/Personal', 'Sonstiges'],
            sucess: false
        };
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
                    gender:   this.formData.gender || 'Keine Angabe',
                    category: this.formData.category,
                    message:  this.formData.message,
                    date:     new Date().toLocaleDateString('de-DE'),
                    time:     new Date().toLocaleTimeString('de-DE')
                };

                const response = await fetch('phpmails/mail.php', {
                    method:  'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body:    JSON.stringify(payload)
                });

                const result = await response.json();

                if (!response.ok || result.error) {
                    throw new Error(result.error || 'Unbekannter Fehler');
                }

                this.successMessage = 'Deine Nachricht wurde erfolgreich gesendet! Vielen Dank für dein Vertrauen.';
                this.sucess = true;
                this.$refs.form.reset();

            } catch (error) {
                console.error('Fehler:', error);
                this.errorMessage = 'Fehler beim Senden der Nachricht. Bitte versuche es später erneut.';
            } finally {
                this.loading = false;
            }
        }
    }
}
</script>