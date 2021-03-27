<template>
    <div>

        <v-list>
            <v-list-item v-for="(item, index) in menuItems" :key="index" link exact :to="{ name: item.link }">
                <v-list-item-action>
                    <v-icon>{{ item.icon }}</v-icon>
                </v-list-item-action>
                <v-list-item-content>
                    <v-list-item-title>{{ item.name }}</v-list-item-title>
                </v-list-item-content>
            </v-list-item>
        </v-list>

    </div>


</template>

<script>
export default {
    data() {
        return {
            menuItems: [
                {
                    name: 'Главная',
                    icon: 'mdi-home',
                    link: 'index',
                },
                {
                    name: 'События',
                    icon: 'mdi-calendar',
                    link: 'events',
                },
                {
                    name: 'Места',
                    icon: 'mdi-map',
                    link: 'places',
                },
                {
                    name: 'Экскурсии',
                    icon: 'mdi-wallet-travel',
                    link: 'trips',
                },
            ]
        }
    },

}
</script>
