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
                cols="12" md="6" lg="4"
            >
                <v-text-field
                    label="Поиск"
                    placeholder="Поиск"
                    v-model="options.search"
                    @keyup="loadResource"
                    outlined
                    dense
                    clearable
                ></v-text-field>
            </v-col>
            <v-col
                class="mt-2 d-flex flex-column"
                cols="12" md="6" lg="4"
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
                <v-slider
                    @change="loadResource"
                    class="mt-3"
                    v-if="options.sort == 'distance'"
                    v-model="distance"
                    label="Растояние"
                    :thumb-color="'red'"
                    thumb-label="always"
                    max="25"
                ></v-slider>
            </v-col>
            <v-col
                class="mt-2 d-flex flex-column"
                cols="12" md="6" lg="4"
            >

            </v-col>
        </v-row>

        <v-row>
            <v-col
                v-for="item in items"
                :key="item.id"
                cols="6"
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
            resource: 'trips'
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
