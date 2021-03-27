<template>
    <div>
        <v-list>
            <v-list-item class="pb-0">
                <v-list-item-content>
                    <v-img
                        max-width="80"
                        style="border-radius: 100%"
                        src="https://randomuser.me/api/portraits/women/85.jpg"
                    ></v-img>
                </v-list-item-content>
            </v-list-item>
        </v-list>

        <v-divider></v-divider>
    </div>


</template>

<script>
export default {
    props: {
        drawer: {
            type: Boolean,
            required: true
        },
    },
}
</script>
