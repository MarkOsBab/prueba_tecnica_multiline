<template>
    <div>
      <div class="card">
        <div class="card-header d-flex flex-row align-items-center justify-content-between">
            <span>Registrar Llamada</span>
            <a href="../../home">Volver al inicio</a>
        </div>
  
        <div class="card-body">
          <ValidationError :errors="formErrors"></ValidationError>
          <div v-if="successForm" class="alert alert-success">
            <span>Llamado creado con éxito</span>
          </div>
          <form @submit.prevent="submitForm">
            <div class="form-group">
                <label for="cliente_id">Cliente:</label>
                <model-list-select 
                    :list="clients" 
                    option-value="cliente_id" 
                    option-text="cliente_nombre" 
                    v-model="cliente_id" 
                    placeholder="Selecciona un cliente"
                ></model-list-select>
            </div>
  
            <div class="form-group">
              <label for="llamada_telefono">Teléfono:</label>
              <input v-model="llamada_telefono" type="text" name="llamada_telefono" class="form-control">
            </div>
  
            <div class="form-group">
              <label for="llamada_observacion">Observación:</label>
              <textarea v-model="llamada_observacion" name="llamada_observacion" class="form-control"></textarea>
            </div>
  
            <button type="submit" class="btn btn-primary my-2">Guardar Llamada</button>
            <div v-if="this.error" class="alert alert-warning">
                <span>{{ this.errorMessage }}</span>
            </div>
          </form>
        </div>
      </div>
    </div>
</template>

<script>
    import ValidationError from '../components/ValidationError.vue';
    export default {
        data() {
            return {
                searchTerm: '',
                clients: [],
                cliente_id: null,
                llamada_telefono: '',
                llamada_observacion: '',
                successForm: false,
                error: false,
                errorMessage: '',
                formErrors: [],
            };
        },
        components: {
            ValidationError,
        },
        methods: {
            getClients() {
                axios.get('/api/clients', this.searchTerm ? { params: { search: this.searchTerm } } : {})
                    .then(response => {
                        this.clients = response.data;
                    })
                    .catch(error => {
                        this.error = true;
                        this.errorMessage = 'Ocurrió un error al obtener los clientes';
                    });
            },
            submitForm() {
                const formData = {
                    cliente_id: this.cliente_id,
                    llamada_telefono: this.llamada_telefono,
                    llamada_observacion: this.llamada_observacion,
                };
                axios.post('/calls/store', formData)
                    .then(response => {
                        this.error = false;
                        this.clearFormErrors();
                        this.successForm = true;
                        this.clearForm();
                        
                    })
                    .catch(error => {
                        if (error.response.status === 422 && error.response.data.errors) {
                            this.formErrors = Object.values(error.response.data.errors).flat();
                        } else {
                            console.log(error.response.data);
                            this.formErrors = ['Ocurrió un error al almacenar la llamada.'];
                        }
                    });
            },
            clearFormErrors() {
                this.formErrors = [];
            },
            clearForm() {
                this.cliente_id = null;
                this.llamada_telefono = null;
                this.llamada_observacion = null;
            }
        },
        mounted() {
            this.getClients();
        }
    };
</script>