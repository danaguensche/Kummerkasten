<template>
    <v-container class="d-flex align-center justify-center" style="min-height: 100vh;">
        <v-card class="mx-auto elevation-4 pa-3 mt-3 mb-3" max-width="350" rounded="lg">
            <v-card-title class="text-h6 text-indigo-darken-2 font-weight-bold text-center pa-2" primary-title>
                Teile diesen Kummerkasten
            </v-card-title>
            <v-card-subtitle class="text-center font-weight-thin pa-1 mb-2">
                Scanne den QR Code 
                mit deinem Smartphone
            </v-card-subtitle>
            <v-divider class="mb-3"></v-divider>
            <v-img class="mx-auto my-2" max-width="150" :src="qrCodeImage" alt="QR Code zum Kummerkasten"
                aspect-ratio="1">
            </v-img>

            <v-card-actions class="pa-0 pt-4">
                <v-btn
                    color="indigo-darken-2"
                    variant="outlined"
                    size="small"
                    rounded="pill"
                    class="px-4 font-weight-bold flex-grow-1 mr-2"
                    @click="router.push('/info')">
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
import qrCodeImage from '../../img/myqrcode_69522.png';
export default {
    name: "QR",
    data() {
        return {
            qrCodeImage,
            router: this.$router
        }
    }
}
</script>