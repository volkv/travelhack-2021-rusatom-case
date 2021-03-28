<template>
    <v-row>
        <v-col
            class="mt-2 d-flex justify-space-between"
            cols="12"
        >
            <div class="text-h4 font-weight-bold">{{ title }}</div>
            <div class="pr-8">
                <v-btn
                    icon
                    link
                    exact
                    :to="{ name: resource }"
                >
                    Подробнее
                    <v-icon>mdi-chevron-right</v-icon>
                </v-btn>
            </div>
        </v-col>

        <v-col
            v-for="item in items"
            :key="item.id"
            cols="12"
            md="6"
            lg="3"
        >
<!--            Карточка активности-->
            <activity-card :item="item" />
        </v-col>
    </v-row>
</template>

<script>

import loadDataMixin from "../../mixins/loadDataMixin";
import ActivityCard from "./ActivityCard";


export default {
    // Миксин универсальной подгрузки ресурса
    mixins: [loadDataMixin],

    components: {
      ActivityCard
    },

    props: {
        title: {
            type: String,
        },
        resource: {
            type: String,
            required: true,
        }
    },

    created() {
        if (this.resource) {
            this.loadResource()
        }
    }
}
</script>
