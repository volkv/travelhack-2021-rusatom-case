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

        <div class="ml-auto" style="position: absolute; z-index: 5; top:8px; right: 8px;" v-if="item.relevance && resource">
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

            <span class="text--grey text-caption" v-if="item.relevance">{{ item.relevance }}</span>

        </v-card-text>

<!--        Окно правки карточки-->
        <v-dialog
            v-if="resource"
            v-model="dialog"
            persistent
            max-width="600px"
        >
            <form-dialog
                :resource="resource"
                :item="item"
                @updated="updated"
                @close="dialog = false" />
        </v-dialog>
    </v-card>
</template>

<script>

import FormDialog from './EditDialog'

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
        resource: {
            type: String,
            required: false,
        }
    },

    methods: {
        prepareDistance(dist) {
            if (dist > 100) {
                return '~' + Math.round(dist/100)*100
            } else if (dist < 10) {
                return Number(dist).toFixed(2)
            }
            return Math.round(dist)
        },
        updated() {
            this.dialog = false
            this.$emit('updated')
        }
    },

    created() {
        setTimeout(()=> this.loading = false, 500 )
    }
}
</script>
