<template>

    <v-card>
        <v-card-title>
            <span class="headline">Работа с записью</span>
        </v-card-title>
        <v-card-text>
            <v-container>
                <v-row>
                    <v-col
                        cols="12"
                    >
                        <v-text-field
                            label="Название"
                            v-model="activeItem.title"
                            required
                        ></v-text-field>
                    </v-col>
                    <v-col
                        cols="12"
                    >
                        <v-text-field
                            label="Релевантость"
                            v-model="activeItem.priority"
                        ></v-text-field>
                    </v-col>
                </v-row>
            </v-container>
        </v-card-text>
        <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn
                color="blue darken-1"
                text
                @click="$emit('close')"
            >
                Close
            </v-btn>
            <v-btn
                color="blue darken-1"
                text
                @click="save"
            >
                Save
            </v-btn>
        </v-card-actions>
    </v-card>
</template>

<script>

import loadDataMixin from "../../mixins/loadDataMixin";

export default {
    mixins: [loadDataMixin],
    data() {
        return {
            dialog: false,
            activeItem: {
                title: '',
                priority: '',
                id: ''
            }
        }
    },
    props: {
        item: {
            type: Object,
            required: false,
        },
        resource: {
            type: String,
            required: true,
        }

    },
    methods: {
        async save() {
            this.saveResource()
            this.$emit('updated')

        }
    },

    created() {
        if(!this.item) return
        this.activeItem = Object.assign({}, this.item)
    },
}
</script>
