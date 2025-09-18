<template>
    <v-card 
        class="mx-auto elevation-4 mt-6 pa-4"
        max-width="800"
        rounded="lg">
        <v-card-title class="text-h5 text-indigo-darken-2 font-weight-bold" primary-title>
            Wie funktioniert's?
        </v-card-title>

        <v-divider class="mb-4"></v-divider>


        <v-card-text>

            <v-list lines="one">
                <v-list-item v-for="item in listItems"> <v-icon icon="mdi mdi-check-circle" color="success"></v-icon>{{ item.content }}</v-list-item>
            </v-list>

        </v-card-text>

    </v-card>
</template>

<script>

export default {
    name: "Info",

    data() {
        return {

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