<template>
    <v-app id="inspire">
        <v-app-bar app>
            <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>

            <v-toolbar-title>Murmansk.travel</v-toolbar-title>
        </v-app-bar>

        <v-navigation-drawer
            v-model="drawer"
            fixed
            temporary
        >
            <nav-menu />
        </v-navigation-drawer>

        <v-main class="grey lighten-5">
            <v-container>
                <router-view></router-view>
            </v-container>
        </v-main>
    </v-app>
</template>

<script>

import NavMenu from './components/base/NavMenu'
export default {
    data: () => ({ drawer: null }),
    components: {
        NavMenu
    },
}
</script>
