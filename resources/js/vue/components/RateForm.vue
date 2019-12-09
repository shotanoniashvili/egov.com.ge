<template>
    <div class="rate-form">
        <form method="post">
            <input v-if="rateId !== null" type="hidden" name="_method" value="PATCH" />
            <input type="hidden" name="_token" :value="csrf" />
            <div class="form-group">
                <div class="row mb-3">
                    <label for="name" class="col-sm-4 control-label text-right">
                        დასახელება
                    </label>
                    <div class="col-sm-4">
                        <input class="form-control required" v-model="rate.name" id="name" placeholder="დასახელება" />
                    </div>
                    <div class="col-sm-4" v-if="errors.name">
                        <span class="help-block">{{ errors.name }}</span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label for="project_category_id" class="col-sm-4 control-label text-right">
                        პროექტის კატეგორია
                    </label>
                    <div class="col-sm-4">
                        <select class="form-control required" id="project_category_id" v-model="rate.project_category_id">
                            <option v-for="projectCategory of categories" :value="projectCategory.id">{{ projectCategory.name }}</option>
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <a class="btn btn-success btn-add-criteria mb-3" @click="addCriteria()">კრიტერიუმის დამატება</a>
                    </div>
                    <div class="col-sm-12" v-if="errors.project_category_id">
                        <span class="help-block">{{ errors.project_category_id }}</span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row mb-3" v-if="rate.criterias.length > 0">
                    <div class="col-sm-12" v-for="(criteria, i) of rate.criterias">
                        <div class="row criteria-container mb-4">
                            <label class="control-label col-sm-4 text-right">
                                კრიტერიუმის დასახელება
                            </label>
                            <div class="col-sm-4">
                                <input class="form-control mb-1" placeholder="კრიტერიუმის დასახელება" type="text" v-model="criteria.name" />
                            </div>
                            <div class="col-md-4">
                                <a class="btn btn-danger" @click="removeCriteria(i)">კრიტერიუმის წაშლა</a>
                                <a class="btn btn-info" @click="addSubcriteria(criteria)">ინდიკატორის დამატება</a>
                            </div>
                            <div class="col-sm-4 offset-4" v-if="criteria.subcriterias.length > 0">
                                <ul class="sub-criteria-container mt-3" style="list-style: none;" v-for="(subcriteria, j) of criteria.subcriterias">
                                    <hr />
                                    <li class="mb-2 position-relative">
                                        <input class="text form-control" type="text" placeholder="ინდიკატორის დასახლება" v-model="subcriteria.name" />
                                        <a class="btn btn-danger btn-remove-subcriteria" @click="removeSubcriteria(criteria, j)"><i class="fa fa-ban"></i> ინდიკატორის წაშლა</a>
                                    </li>
                                    <li class="mb-2">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" :name="'crit'+i+j" :id="'sub_free'+i+j" type="radio" v-model="subcriteria.point_type" value="free_point">
                                            <label class="form-check-label" :for="'sub_free'+i+j">საექსპერტო შეფასება</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" :name="'crit'+i+j" :id="'sub_percent'+i+j" type="radio" v-model="subcriteria.point_type" value="percentable">
                                            <label class="form-check-label" :for="'sub_percent'+i+j">პროცენტული მაჩვენებელი</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" :name="'crit'+i+j" :id="'sub_custom'+i+j" type="radio" v-model="subcriteria.point_type" value="custom_criteria">
                                            <label class="form-check-label" :for="'sub_custom'+i+j">მორგერბული ვარიანტები</label>
                                        </div>
                                    </li>
                                    <li class="mb-2">
                                        <div class="yes-or-no-field-container" v-if="subcriteria.point_type === 'custom_criteria'">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <a class="btn btn-primary mb-2" @click="addCustom(subcriteria)">მნიშვნელობის დამატება</a>
                                                </div>
                                                <div class="value_container col-md-12" v-if="subcriteria.customs.length">
                                                    <div class="row position-relative mb-2" v-for="(custom, k) of subcriteria.customs">
                                                        <div class="col-md-6">
                                                            <input class="text form-control" type="text" placeholder="დასახელება" v-model="custom.title" />
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input class="text form-control" type="text" placeholder="ქულა" v-model="custom.point" />
                                                        </div>
                                                        <a style="right: -198px;" class="btn btn-danger btn-remove-subcriteria" @click="removeCustomCriteria(subcriteria, k)"><i class="fa fa-ban"></i> მნიშვნელობის წაშლა</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" name="data" :value="jsonData" />
            <div class="form-group">
                <div class="row">
                    <div class="offset-sm-4 col-sm-4">
                        <a class="btn btn-danger" href="/admin/rates">
                            უარყოფა
                        </a>
                        <button type="submit" class="btn btn-success">
                            შენახვა
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        name: "RateForm",

        props: {
            rateId: {
                default: null
            },
            csrf: String
        },

        data: function () {
            return {
                errors: {},
                rate: {
                    name: '',
                    project_category_id: '',
                    criterias: [
                        {
                            name: '',
                            subcriterias: [{
                                name: '',
                                point_type: 'free_point',
                                customs: [{
                                    title: '',
                                    point: ''
                                }]
                            }]
                        }
                    ]
                },
                categories: []
            }
        },

        computed: {
            jsonData: function () {
                return JSON.stringify(this.rate);
            }
        },

        mounted() {
            this.loadProjectCategories();

            if(this.rateId !== null) {
                this.loadRateData();
            }
        },

        methods: {
            loadProjectCategories() {
                axios.get('/api/project-categories/for-rate')
                    .then(response => {
                        this.categories = response.data.data;
                    })
                    .catch(error => {
                        console.log(error.message);
                    });
            },

            loadRateData() {
                axios.get('/admin/rates/'+this.rateId+'/json')
                    .then(response => {
                        this.rate = response.data.data;

                        this.categories.unshift(this.rate.project_category);
                    })
                    .catch(error => {
                        console.log(error.message);
                    });
            },

            addCustom(subcriteria) {
                subcriteria.customs.push({
                    title: '',
                    point: 0,
               });
            },

            removeCriteria(i) {
                this.rate.criterias.splice(i, 1);
            },

            removeSubcriteria(criteria, i) {
                criteria.subcriterias.splice(i, 1);
            },

            removeCustomCriteria(subcriteria, i) {
                subcriteria.customs.splice(i, 1);
            },

            addCriteria() {
                this.rate.criterias.push(this.getEmptyCriteria());
            },

            addSubcriteria(criteria) {
                criteria.subcriterias.push(this.getEmptySubcriteria());
            },

            getEmptyCriteria() {
                const emptySubcriteria = this.getEmptySubcriteria();
                return {
                    name: '',
                    percent_in_total: '',
                    subcriterias: [emptySubcriteria]
                };
            },

            getEmptySubcriteria() {
                return {
                    name: '',
                    point_type: 'free_point',
                    customs: [{
                        title: '',
                        point: ''
                    }]
                }
            }
        },
    }
</script>

<style scoped>
    .btn-remove-subcriteria {
        position: absolute;
        top: 0;
        right: -230px;
    }
</style>