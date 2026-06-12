<template>
<v-container fluid class="mobile-page d-flex justify-center">
    <v-card class="mobile-card mx-auto elevation-4 rounded-lg">
        <div class="pa-4 pa-sm-6">
          <v-card-title
            class="text-h6 text-indigo-darken-2 font-weight-bold text-center pa-0 mb-2"
            primary-title
          >
            Teile diesen Kummerkasten
          </v-card-title>
  
          <v-divider class="mb-4"></v-divider>
  
          <v-img
            class="mx-auto my-4 qr-image"
            :src="qrCodeImage"
            alt="QR Code zum Kummerkasten"
            aspect-ratio="1"
            max-width="180"
            contain
          />
  
          <v-card-actions class="pa-0 mobile-actions">
            <v-btn
              color="indigo-darken-2"
              variant="outlined"
              rounded="pill"
              class="px-4 font-weight-bold w-100"
              min-height="44"
              @click="router.push('/form')"
            >
              <v-icon class="mr-1" size="small">mdi-arrow-left</v-icon>
              Zurück
            </v-btn>
          </v-card-actions>
        </div>
      </v-card>
    </v-container>
  </template>
  
  <script>
  import qrCodeImage from '../../img/qr-jugendhilfe.png';
  
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
  