<template>
    <v-card
        :loading="loading"
        class="mx-auto my-2"
    >
        <template slot="progress">
            <v-progress-linear
                color="deep-purple"
                height="10"
                indeterminate
            ></v-progress-linear>
        </template>

        <v-img
            height="200"
            src="https://cdn.vuetifyjs.com/images/cards/cooking.png"
        ></v-img>

        <v-card-text>
            <v-row
                v-if="item.rating"
                align="center"
                class="mx-0 my-0"
            >
                <v-rating
                    :value="item.rating"
                    color="amber"
                    dense
                    half-increments
                    readonly
                    size="14"
                ></v-rating>

                <div class="grey--text ml-4">
                    {{ item.rating }}
                </div>
            </v-row>

            <div class="my-0 text-h6 pb-0">{{ item.title }}</div>


            <v-chip-group v-if="item.label">
                <v-chip>{{item.label}}</v-chip>
            </v-chip-group>

        </v-card-text>
    </v-card>
</template>

<script>

export default {
    data() {
        return {
            loading: true
        }
    },

    props: {
        item: {
            type: Object,
            required: true,
        },
    },

    created() {
        setTimeout(()=> this.loading = false, 500 )
    }
}
</script>
