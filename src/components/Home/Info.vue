<template>
    <v-container class="d-flex align-center justify-center" style="min-height: 100vh;">
        <v-card class="mx-auto elevation-4 pa-12 mt-6" max-width="800" rounded="lg">
            <v-card-title class="text-h5 text-indigo-darken-2 font-weight-bold" primary-title>
                Wie funktioniert's?
            </v-card-title>

            <v-divider class="mb-4"></v-divider>


            <v-card-text>

                <v-list lines="one">
                    <v-list-item v-for="item in listItems"> <v-icon icon="mdi mdi-check-circle"
                            color="success"></v-icon>{{ item.content }}</v-list-item>
                </v-list>

            </v-card-text>

            <v-card-actions class="justify-center pa-6">

                <v-row>
                    <v-col cols="12" md="6" class="text-left">
                
                <v-btn
                    color="indigo-darken-2"
                    variant="elevated"
                    size="small"
                    rounded="pill"
                    class="px-5 font-weight-bold elevation-8"
                    @click="router.push('/home')">
                    Zurück
                </v-btn>

                </v-col>

                <v-col cols="12" md="6" class="text-right">
                <v-btn
                    color="indigo-darken-2"
                    variant="elevated"
                    size="small"
                    rounded="pill"
                    class="px-5 font-weight-bold elevation-8"
                    @click="router.push('/form')">
                    Weiter
                </v-btn>
                </v-col>
            </v-row>
            </v-card-actions>

        </v-card>
    </v-container>
</template>

<script>

export default {
    name: "Info",

    data() {
        return {
            router: this.$router,

            listItems: [
                { content: ' Fülle das Formular aus' },
                { content: ' Klicke auf Absenden' },
                { content: ' Du kannst wählen ob du Anonym bleiben möchtest' }
            ]

        }
    },

}
</script>

<style scoped>
.v-list-item:hover {
    transform: translateY(-2px);
}
</style>