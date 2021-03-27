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
                    size="12"
                ></v-rating>

                <div class="grey--text ml-4">
                    {{ item.rating }}
                </div>
            </v-row>

            <v-row
                justify="space-between"
                class="mx-0 my-0"
            >
                <div class="col-8">
                    <div class="text-h6">{{ item.title }}</div>
                </div>
                <div class="col-3">
                    <div class="text-truncate text-small mt-1 text-right red--text" v-if="item.distance">{{ prepareDistance(item.distance) }} км</div>
                </div>
            </v-row>



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

    methods: {
        prepareDistance(dist) {
            if (dist > 100) {
                return '~' + Math.round(dist/100)*100
            }
            return Math.round(dist)
        }
    },

    created() {
        setTimeout(()=> this.loading = false, 500 )
    }
}
</script>
