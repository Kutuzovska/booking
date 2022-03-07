const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 1500,
    timerProgressBar: true,
});

const Loader = {
    template: `<div class="app-overlay">
        <div class="lds-ripple"><div></div><div></div></div>
    </div>`
}

const Auth = {
    template: `<div class="hero-body">
        <div class="container is-flex is-justify-content-center">
            <form @submit.prevent="submit" class="box" style="width: 400px;">
                <div class="field">
                    <label class="label">Имя</label>
                    <div class="control">
                        <input v-model="name" class="input" required type="text" placeholder="Иван">
                    </div>
                </div>
                <div class="field">
                    <label class="label">Пароль</label>
                    <div class="control">
                        <input v-model="password" class="input" required type="text" placeholder="qerty123">
                    </div>
                    <small>Демо вход <b>admin</b> / <b>admin</b></small>
                </div>
                <div class="field">
                    <button class="button is-fullwidth is-primary">Вход</button>
                </div>
            </form>
        </div>
    </div>`,
    data: () => ({
        name: 'admin',
        password: 'admin',
    }),
    methods: {
        async submit() {
            try {
                const { data } = await axios({
                    method: 'POST',
                    url: '/v1/users/login',
                    data: {
                        name: this.name,
                        password: this.password
                    },
                });

                localStorage.setItem('token', data);
                Toast.fire({
                    icon: 'success',
                    title: 'Добрый день!'
                });
                await this.$emit('enter');
            } catch (e) {
                Toast.fire({
                    icon: 'error',
                    title: 'Что то пошло не так...'
                });
                console.error(e);
            }
        },
    },
};

Vue.createApp({
    components: { Auth, Loader },
    template: `
        <transition name="fade" mode="out-in">
            <Auth v-if="!isAuth" @enter="isAuth = true"/>
            <div v-else class="app has-background-white-bis p-3 is-relative">
                <form @submit.prevent="search" class="box mr-3">
                    <div class="field">
                        <label class="label">Дата заселения</label>
                        <div class="control">
                            <input class="input" required type="date" v-model="from" :min="now">
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Дата выезда</label>
                        <div class="control">
                            <input class="input" required type="date" v-model="to" :min="this.from">
                        </div>
                    </div>
                    <div class="field">
                        <button class="button is-fullwidth is-primary">Поиск</button>
                    </div>
                </form>
                <div class="box">
                    <table class="table is-fullwidth">
                        <thead>
                        <tr>
                            <th>Категория</th>
                            <th colspan="2">Свободно номеров</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="category in categories" :key="category.id">
                            <td>{{ category.name }}</td>
                            <td style="min-width: 300px">{{ category.count }}</td>
                            <td class="has-text-right">
                                <button class="button is-small is-link" @click="book(category.id)">
                                    Забронировать
                                </button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <transition name="fade" mode="out-in">
                    <Loader v-if="isLoading"/>
                </transition>
            </div>
        </transition>
    `,
    data: () => ({
        now: null,
        from: null,
        to: null,
        categories: [],
        isLoading: false,
        isAuth: !!localStorage.getItem('token'),
    }),
    methods: {
        async getData() {
            try {
                this.isLoading = true;
                if (this.from === null) this.setDate();

                const { data } = await axios({
                    method: 'GET',
                    url: '/v1/rooms',
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`,
                    },
                    params: {
                        from: this.from,
                        to: this.to,
                    },
                });

                this.categories = data;
            } catch (e) {
                Toast.fire({
                    icon: 'error',
                    title: 'Что то пошло не так...',
                });
                console.error(e);
            } finally {
                this.isLoading = false;
            }
        },
        setDate() {
            const date = new Date();
            this.now = this.format(date);
            this.from = this.format(date);

            date.setDate(date.getDate() + 7);
            this.to = this.format(date);
        },
        format(date) {
            const year = date.getFullYear();
            const month = `0${date.getMonth()}`.slice(-2);
            const day = `0${date.getDate()}`.slice(-2);
            return `${year}-${month}-${day}`;
        },
        async book(id) {
            try {
                this.isLoading = true;
                await axios({
                    method: 'POST',
                    url: '/v1/booking',
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`,
                    },
                    data: {
                        room_type_id: id,
                        from: this.from,
                        to: this.to,
                    },
                });

                await this.getData();
            } catch (e) {
                Toast.fire({
                    icon: 'error',
                    title: 'Что то пошло не так...',
                });
                console.error(e);
            } finally {
                this.isLoading = false;
            }
        },
        async search() {
            await this.getData();
        },
    },
    watch: {
        isAuth: {
            immediate: true,
            handler() {
                this.getData();
            },
        },
        from() {
            if (this.from > this.to) [this.to, this.from] = [this.from, this.to];
        }
    },
}).mount('#app');
