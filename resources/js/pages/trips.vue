<template>
    <v-container>
        <v-row>
            <v-col
                class="mt-2 d-flex justify-space-between"
                cols="12"
            >
                <div class="text-h4 font-weight-bold"> Самые интересные экскурсии </div>
            </v-col>
        </v-row>

        <v-row>
            <v-col
                class="mt-2 d-flex"
                cols="12" md="6"
            >
                <v-text-field
                    label="Поиск"
                    placeholder="Поиск"
                    v-model="options.search"
                    @keyup="loadResource"
                    @click:clear="loadResource"
                    outlined
                    dense
                    clearable
                ></v-text-field>
            </v-col>
            <v-col
                class="mt-2 d-flex flex-column"
                cols="12" md="6"
            >
                <v-select
                    :items="sortOptions"
                    v-model="options.sort"
                    label="Сортировка"
                    item-text="text"
                    item-value="value"
                    @change="loadResource"
                    outlined
                    dense
                ></v-select>

            </v-col>
        </v-row>

        <v-row>
            <v-col
                v-for="item in items"
                :key="item.id"
                cols="12"
                md="6"
                lg="3"
            >
                <activity-card :item="item" />
            </v-col>
        </v-row>
    </v-container>
</template>
<script>

import ActivityCard from "../components/base/ActivityCard";
import loadDataMixin from "../mixins/loadDataMixin";
export default {
    data() {
        return {
            resource: 'trips',
            sortOptions: [
                {
                    text: 'По релевантонсти',
                    value: 'relevance'
                },
                {
                    text: 'По новизне',
                    value: 'created_at'
                },
                {
                    text: 'По рейтингу',
                    value: 'avg'
                }
            ],
        }
    },
    components: {
        ActivityCard
    },
    mixins: [loadDataMixin],
    created() {
        this.loadResource()
    }

}
</script>
