<template>
    <v-card class="mx-auto elevation-4 pa-4 mt-6 mb-6" max-width="600" rounded="lg">
        <v-card-title class="text-h5 text-indigo-darken-2 font-weight-bold text-center" primary-title>
            Teile diesen Kummerkasten
        </v-card-title>
        <v-card-subtitle class="text-center mb-4">
            Scanne den QR Code mit deinem Smartphone
        </v-card-subtitle>

        <v-divider class="mb-4"></v-divider>

        <v-img class="mx-auto my-4" max-width="200" :src="qrCodeImage" alt="QR Code zum Kummerkasten"></v-img>

    </v-card>
</template>

<script>
import qrCodeImage from '../../img/myqrcode_69522.png';
export default {
    name: "QR",
    data() {
        return {
            qrCodeImage
        }
    }
}

</script>