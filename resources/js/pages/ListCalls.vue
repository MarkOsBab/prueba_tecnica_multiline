<template>
    <div class="m-2 p-2">
        <div class="m-2 p-3">
            <h5>Filtros</h5>
            <div class="d-flex flex-row align-items-center justify-content-between">
                <div class="m-2 w-100">
                    <label for="cliente_id">Filtrar por cliente:</label>
                    <model-list-select 
                        :list="clients" 
                        option-value="cliente_id" 
                        option-text="cliente_nombre" 
                        v-model="cliente_id" 
                        placeholder="Filtra por un cliente"
                        @input="filterCalls"
                    ></model-list-select>
                </div>
                <div class="m-2 w-100">
                    <label for="cliente_id">Filtrar por usuario:</label>
                    <model-list-select 
                        :list="users" 
                        option-value="id" 
                        option-text="name" 
                        v-model="user_id" 
                        placeholder="Filtra por un usuario"
                        @input="filterCalls"
                    ></model-list-select>
                </div>
            </div>
            <div class="d-flex flex-row align-items-center justify-content-between">
                <div class="m-2 w-100">
                    <label for="call_phone">Filtrar por teléfono</label>
                    <input type="text" class="form-control" placeholder="Filtrar por teléfono" v-model="call_phone" @input="debounceFilterCalls">
                </div>
                <div class="m-2 w-100">
                    <label for="call_observation">Filtrar por observación</label>
                    <input type="text" class="form-control" placeholder="Filtrar por observación" v-model="call_observation" @input="debounceFilterCalls">
                </div>
            </div>
            <div class="m-2">
                <label for="call_date">Filtrar por fecha de llamada:</label>
                <input type="date" class="form-control" v-model="call_date" @change="filterCalls">
            </div>
            <div class="d-flex flex-row align-items-center justify-content-end m-2">
                <button @click="clearFilters" class="btn btn-secondary">Borrar filtros</button>
            </div>
        </div>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Cliente</th>
                    <th>Usuario</th>
                    <th>Observaciones</th>
                    <th>Teléfono de llamada</th>
                    <th>Fecha de llamada</th>
                </tr>
            </thead>
            <tbody>
                <tr v-if="!loadingCalls" v-for="call of calls.data">
                    <td>{{ call.id }}</td>
                    <td>{{ call.client.cliente_nombre }}</td>
                    <td>{{ call.user.name }}</td>
                    <td>{{ call.llamada_observacion }}</td>
                    <td>{{ call.llamada_telefono }}</td>
                    <td>{{ call.llamada_fecha }}</td>
                </tr>
                <tr v-if="calls.data.length <= 0">
                    <td colspan="6">No hay llamadas registradas.</td>
                </tr>
            </tbody>
        </table>
        <Bootstrap5Pagination
            :data="calls"
            @pagination-change-page="getCalls"
        />
    </div>
</template>
<script>
    import { Bootstrap5Pagination } from 'laravel-vue-pagination';
    import debounce from 'lodash/debounce';
    export default {
        components: {
            Bootstrap5Pagination,
        },
        data() {
            return {
                calls: { data: [] },
                clients: [],
                users: [],
                cliente_id: null,
                user_id: null,
                call_date: null,
                call_observation: null,
                call_phone: null,
                error: false,
                errorMessage: '',
            }
        },
        methods: {
            debounceFilterCalls: debounce(async function() {
                await this.getCalls();
            }, 700),
            async getClients() {
                await axios.get('/api/clients', this.searchTerm ? { params: { search: this.searchTerm } } : {})
                    .then(response => {
                        this.clients = response.data;
                        this.loadingCalls = false;
                    })
                    .catch(error => {
                        this.loadingCalls = false;
                        this.error = true;
                        this.errorMessage = 'Ocurrió un error al obtener los clientes';
                    });
            },
            async getUsers() {
                await axios.get('/api/users', this.userSearchTerm ? { params: { search: this.userSearchTerm } } : {})
                    .then(response => {
                        this.users = response.data;
                        this.loadingCalls = false;
                    })
                    .catch(error => {
                        this.error = true;
                        this.errorMessage = 'Ocurrió un error al obtener los usuarios';
                    })
            },
            async getCalls(page = 1) {
                await axios.get(`/api/calls?page=${page}`, {
                    params: {
                        client_id: this.cliente_id,
                        user_id: this.user_id,
                        call_date: this.call_date,
                        call_observation: this.call_observation,
                        call_phone: this.call_phone,
                    }
                })
                .then(response => {
                    this.calls = response.data;
                    this.loadingCalls = false;
                })
                .catch(error => {
                    this.error = true;
                    this.errorMessage = 'Ocurrió un error al obtener las llamadas.';
                })
            },
            async filterCalls() {
                await this.getCalls();
                this.loadingCalls = false;
            },
            async clearFilters() {
                this.cliente_id = null;
                this.user_id = null;
                this.call_date = null;
                this.call_observation = null;
                this.call_phone = null;
                await this.getCalls();
            }
        },
        watch: {
            cliente_id: async function(newClienteId, oldClienteId) {
                if (newClienteId !== oldClienteId) {
                    await this.filterCalls();
                }
            },
            user_id: async function(newUserId, oldUserId) {
                if (newUserId !== oldUserId) {
                    await this.filterCalls();
                }
            },
            call_date: async function(newCallDate, oldCallDate) {
                if(newCallDate != oldCallDate) {
                    await this.filterCalls();
                }
            },
            call_observation: async function(newCallObservation, oldCallObservation) {
                if(newCallObservation != oldCallObservation) {
                    await this.filterCalls();
                }
            },
            call_phone: async function(newCallPhone, oldCallPhone) {
                if(newCallPhone != oldCallPhone) {
                    await this.filterCalls();
                }
            }
        },
        async mounted() {
            await this.getClients();
            await this.getUsers();
            await this.getCalls();
        }
    }
</script>