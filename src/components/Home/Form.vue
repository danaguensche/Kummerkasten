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
                        density="compact" prepend-inner-icon="mdi-account" class="mb-3" color="indigo-darken-2">
                    </v-text-field>

                    <v-text-field v-model="formData.lastname" label="Nachname (optional)" variant="outlined"
                        density="compact" prepend-inner-icon="mdi-account" class="mb-3" color="indigo-darken-2">
                    </v-text-field>

                    <v-select v-model="select" :items="items" :rules="selectRules" label="Kategorie" variant="outlined"
                        density="compact" prepend-inner-icon="mdi-tag" class="mb-3" color="indigo-darken-2" required>
                    </v-select>

                    <v-textarea v-model="formData.message" label="Deine Nachricht" :rules="messageRules" required
                        variant="outlined" density="compact" prepend-inner-icon="mdi-message-text" class="mb-3"
                        color="indigo-darken-2" rows="3" counter="500" auto-grow>
                    </v-textarea>
                </v-form>
            </v-card-text>

            <v-card-actions class="pa-0 pt-2">
                <v-checkbox v-model="formData.anonymous" label="Anonym bleiben" color="indigo-darken-2"
                    density="compact" class="flex-grow-0">
                </v-checkbox>

                <v-spacer></v-spacer>

                <v-btn color="indigo-darken-2" variant="elevated" size="small" rounded="pill"
                    class="px-4 font-weight-bold" :disabled="!valid" @click="submitForm">
                    <v-icon class="mr-1" size="small">mdi-send</v-icon>
                    Absenden
                </v-btn>
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
            error: null,
            formData: {
                firstname: '',
                lastname: '',
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
            select: null
        };
    },
    methods: {
        submitForm() {
            if (this.$refs.form.validate()) {
                // Form is valid, proceed with submission logic
                console.log('Form submitted:', this.formData);
                // Reset form after submission
                this.$refs.form.reset();
            } else {
                console.log('Form is invalid');
            }
        }
    }
}
</script>