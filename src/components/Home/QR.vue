<template>
    <v-card class="mx-auto elevation-4 pa-3 mt-3 mb-3" max-width="350" rounded="lg">
        <v-card-title class="text-h6 text-indigo-darken-2 font-weight-bold text-center pa-2" primary-title>
            Teile diesen Kummerkasten
        </v-card-title>
        <v-card-subtitle class="text-center text-body-2 pa-1 mb-2">
            Scanne den QR Code mit deinem Smartphone
        </v-card-subtitle>
        <v-divider class="mb-3"></v-divider>
        <v-img 
            class="mx-auto my-2" 
            max-width="150" 
            :src="qrCodeImage" 
            alt="QR Code zum Kummerkasten"
            aspect-ratio="1">
        </v-img>
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