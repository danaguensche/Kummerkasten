<template>
    <v-container class="d-flex align-center justify-center" style="min-height: 100vh;">
        <v-card class="mx-auto elevation-4 pa-6" max-width="500" rounded="lg">
            <v-card-title class="text-h6 text-indigo-darken-2 font-weight-bold pa-0 mb-2" primary-title>
                Wie funktioniert's?
            </v-card-title>
            <v-divider class="mb-3"></v-divider>
            <v-card-text class="pa-0">
                <v-list lines="one" density="compact">
                    <v-list-item 
                        v-for="item in listItems" 
                        :key="item.content"
                        class="px-0 mb-1">
                        <template v-slot:prepend>
                            <v-icon 
                                icon="mdi-check-circle" 
                                color="success" 
                                size="small"
                                class="mr-3">
                            </v-icon>
                        </template>
                        <v-list-item-title class="text-body-2" style="white-space: pre-line;">
                            {{ item.content }}
                        </v-list-item-title>
                    </v-list-item>
                </v-list>
            </v-card-text>
            <v-card-actions class="pa-0 pt-4">
                <v-btn
                    color="indigo-darken-2"
                    variant="outlined"
                    size="small"
                    rounded="pill"
                    class="px-4 font-weight-bold flex-grow-1 mr-2"
                    @click="router.push('/home')">
                    <v-icon class="mr-1" size="small">mdi-arrow-left</v-icon>
                    Zurück
                </v-btn>
                <v-btn
                    color="indigo-darken-2"
                    variant="elevated"
                    size="small"
                    rounded="pill"
                    class="px-4 font-weight-bold flex-grow-1"
                    @click="router.push('/form')">
                    Weiter
                    <v-icon class="ml-1" size="small">mdi-arrow-right</v-icon>
                </v-btn>
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
                { content: 'Fülle das Formular aus' },
                { content: 'Klicke auf Absenden' },
                { content: 'Du kannst wählen ob du Anonym\nbleiben möchtest' }
            ]
        }
    },
}
</script>