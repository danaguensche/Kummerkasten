<template>
    <v-card class="mx-auto elevation-4 mt-6 pa-6" max-width="800" rounded="lg">
        <v-card-title class="text-h5 text-indigo-darken-2 font-weight-bold mb-2" primary-title>
            Dein Anliegen
        </v-card-title>
        <v-divider class="mb-4"></v-divider>
        <v-card-text class="pa-0">
            <v-form ref="form" v-model="valid" @submit.prevent="submitForm">
                <v-container class="pa-0">
                    <v-row no-gutters>
                        <v-col cols="12" md="6" class="pr-md-2">
                            <v-text-field 
                                v-model="formData.firstname" 
                                label="Vorname (optional)" 
                                variant="outlined"
                                density="comfortable" 
                                prepend-inner-icon="mdi-account"
                                class="mb-4"
                                color="indigo-darken-2">
                            </v-text-field>
                        </v-col>
                        <v-col cols="12" md="6" class="pl-md-2">
                            <v-text-field 
                                v-model="formData.lastname" 
                                label="Nachname (optional)" 
                                variant="outlined"
                                density="comfortable" 
                                prepend-inner-icon="mdi-account"
                                class="mb-4"
                                color="indigo-darken-2">
                            </v-text-field>
                        </v-col>
                    </v-row>
                    <v-row no-gutters>
                        <v-col cols="12">
                            <v-select 
                                v-model="select" 
                                :items="items" 
                                :rules="selectRules" 
                                label="Kategorie" 
                                variant="outlined" 
                                density="comfortable" 
                                prepend-inner-icon="mdi-tag" 
                                class="mb-4"
                                color="indigo-darken-2"
                                required>
                            </v-select>
                        </v-col>
                    </v-row>
                    <v-row no-gutters>
                        <v-col cols="12">
                            <v-textarea 
                                v-model="formData.message" 
                                label="Deine Nachricht" 
                                :rules="messageRules" 
                                required
                                variant="outlined" 
                                density="comfortable" 
                                prepend-inner-icon="mdi-message-text" 
                                class="mb-4"
                                color="indigo-darken-2"
                                rows="4"
                                counter="500"
                                auto-grow>
                            </v-textarea>
                        </v-col>
                    </v-row>
                </v-container>
            </v-form>
        </v-card-text>
        <v-card-actions class="pt-0">
            <v-row no-gutters class="align-center">
                <v-col cols="12" md="6" class="text-left">
                    <v-checkbox 
                        v-model="formData.anonymous" 
                        label="Anonym bleiben" 
                        color="indigo-darken-2"
                        density="comfortable">
                    </v-checkbox>
                </v-col>
                <v-col cols="12" md="6" class="text-right">
                    <v-btn 
                        color="indigo-darken-2" 
                        variant="elevated"
                        size="large"
                        class="text-white px-8"
                        :disabled="!valid"
                        @click="submitForm">
                        <v-icon left class="mr-2">mdi-send</v-icon>
                        Absenden
                    </v-btn>
                </v-col>
            </v-row>
        </v-card-actions>
    </v-card>
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