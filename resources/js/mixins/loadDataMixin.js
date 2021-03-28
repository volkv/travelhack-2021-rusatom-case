export default {

    data() {
        return {
            options: {},
            localRadius: 10,
            disnanceSwitch: false,
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
                },
                {
                    text: 'По рейтингу',
                    value: 'avg'
                }
            ],
            items: [],
            userLocation: null,
            loading: true,
        }
    },

    methods: {
        //Загрузка ресурса после резолва параметров запроса
        async loadResource() {
            this.loading = true
            await this.getParams().then((res) => {
                console.log('Загрузка ресурса')
                this.$axios.get(this.resource, {
                    params: res
                }).then((res) => {
                    this.items = res.data.data
                    this.loading = false
                })
            })


        },
        // Ассинхронное получение локации
        async getLocation() {
            return new Promise(resolve => {
                if(this.userLocation){
                    console.log('already set')
                    resolve(this.options.userLocation = this.userLocation)
                }
                if (navigator.geolocation) {
                    // let value = '55.71567700,37.55216600'
                    // this.userLocation = value
                    // resolve(value)
                    navigator.geolocation.getCurrentPosition(async (res) => {
                        let value = res.coords.latitude + ',' + res.coords.longitude
                        this.userLocation = value
                        resolve(value)
                    })
                } else {
                    alert("Geolocation is not supported by this browser.");
                }
            })

        },

        //Асинхронное получение параметров загрузки
        async getParams() {
            if(this.options.sort && this.options.sort == 'distance') {
                await this.getLocation().then(res => {
                    this.options.userLocation = res
                })
            }

            console.log(this.disnanceSwitch)
            if (this.disnanceSwitch) {
                this.options.locationRadius = this.localRadius
                await this.getLocation().then(res => {
                    this.options.userLocation = res
                })
            } else {
                console.log('Switch disabled')
                delete this.options['locationRadius']
            }

            return this.options
        },

        saveResource() {
            this.$axios.put(this.resource + '/' + this.activeItem, this.activeItem).then((res) => {
            })
        }



    },

    watch: {
        localRadius() {
            this.options.locationRadius = this.localRadius
        }
    },


}
