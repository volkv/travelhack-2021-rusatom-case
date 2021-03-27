<template>
    <v-card

        :loading="loading"
        class="mx-auto my-2"
        style="position: relative;"
    >
        <template slot="progress">
            <v-progress-linear
                color="deep-purple"
                height="10"
                indeterminate
            ></v-progress-linear>
        </template>

        <div class="ml-auto" style="position: absolute; z-index: 5; top:8px; right: 8px;" v-if="item.relevance">
            <v-btn
                class="mx-2"
                fab
                dark
                small
                dense
                color="tranparent"
                @click="dialog=true"
            >
                <v-icon dark>
                    mdi-pencil
                </v-icon>
            </v-btn>
        </div>

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

        <v-dialog
            v-model="dialog"
            persistent
            max-width="600px"
        >
            <form-dialog
                :item="item"
                @close="dialog = false" />
        </v-dialog>
    </v-card>
</template>

<script>

import FormDialog from './FormDialog'

export default {
    components: {
        FormDialog
    },
    data() {
        return {
            loading: true,
            dialog: false,
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
        },
    },

    created() {
        setTimeout(()=> this.loading = false, 500 )
    }
}
</script>
