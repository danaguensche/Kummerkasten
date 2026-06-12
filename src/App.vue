<template>
    <div id="app" class="page">
        <router-view></router-view>
    </div>
</template>

<script>
export default {
    name: 'App',
    data() {
        return {
            selectedLang: 'de',
        };
    },
    provide() {
        return {
            lang: this,
        };
    },
};
</script>

<style>
.page {
    min-height: 100dvh;
    background-image: url('./img/v904-nunny-012.jpg');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
}

.mobile-page {
    min-height: 100dvh;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 12px;
}

.mobile-card {
    width: 100%;
    max-width: 380px;
    min-height: 340px;
    padding: 24px;
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.mobile-btn {
    min-height: 44px;
}

</style>