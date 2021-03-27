<template>
    <v-container>
            <activity-row :title="'События'" :resource="'events'" />
            <activity-row :title="'Места'" :resource="'places'" />
            <activity-row :title="'Экскурсии'" :resource="'trips'" />
    </v-container>
</template>


<script>

import ActivityRow from '../components/base/ActivityRow'

export default {
    components: {
        ActivityRow
    }

}
</script>
