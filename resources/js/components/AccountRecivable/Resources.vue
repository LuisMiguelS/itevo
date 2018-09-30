<template>
    <div class="col-md-4">
        <div class="box">
            <div class="box-header with-border"><h3 class="box-title">Recursos</h3></div>
            <div class="box-body">
                <div class="form-group">
                    <div class="custom-control custom-checkbox" v-for="resource in getCourseResources">
                        <div v-if="! findResource(resource.id)">
                            <input class="custom-control-input"
                                   type="checkbox"
                                   :id="resource.id"
                                   :value="resource"
                                   v-model="resources">
                            <label class="custom-control-label" :for="resource.id">{{ resource.name }} - costo {{ resource.price | currency }}</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        name: "Resources",
        props: ['invoice'],
        data() {
          return {
              resources: [],
          }
        },
        watch: {
            resources(newValue) {
                if(newValue) {
                   this.$emit('change-resources', newValue);
                }
            }
        },
        methods: {
            findResource(id) {
                let value = _.find(this.getInvoiceResources, (resource) => {
                    return resource.id == id;
                });

                if (value) {
                    return true
                }

                return false;
            },
        },
        computed: {
            getCourseResources() {
                return this.invoice.course_period[0].resources;
            },
            getInvoiceResources() {
                return this.invoice.resources;
            }
        }
    }
</script>