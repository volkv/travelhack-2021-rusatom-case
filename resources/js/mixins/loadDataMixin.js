export default {

    data() {
        return {
            filter: {},
            options: {},
            distance: 10,
            sortOptions: [
                {
                    text: 'По релевантонсти',
                    value: 'relevance'
                },
                {
                    text: 'По дистанции',
                    value: 'distance'
                },
                {
                    text: 'По новизне',
                    value: 'created_at'
                }
            ]

        }
    },

    methods: {
        async loadResource() {
            if (this.options.sort && this.options.sort == 'distance') {
                if(!this.options.distance) {
                    this.options.distance = this.distance
                }
                await this.getLocation()
            } else (delete this.options['distance'])
            await this.$store.dispatch(this.resource + '/loadWhere', this.payload)
        },

        async getLocation() {
            if (navigator.geolocation) {
                return new Promise(resolve => {
                    navigator.geolocation.getCurrentPosition(async (res) => {
                        this.options.userLocation = res.coords.latitude + ',' + res.coords.longitude
                        resolve()
                    })
                })
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        },
    },

    watch: {
        distance() {
            this.options.distance = this.distance
        }
    },

    computed: {
        items() {
            return this.$store.getters[ this.resource + '/all'];
        },
        payload() {
            return {
                filter: this.filter,
                options: this.options
            }
        }
    },
}
