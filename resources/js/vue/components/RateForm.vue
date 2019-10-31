<template>
    <div class="rate-form">
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
                    <button class="btn btn-success btn-add-criteria mb-3" @click="addCriteria">კრიტერიუმის დამატება</button>
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
                            <input class="form-control" placeholder="საერთო ქულის პროცენტი" type="number" v-model="criteria.percent_in_total" />
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-danger" @click="removeCriteria(i)">კრიტერიუმის წაშლა</button>
                            <button class="btn btn-info" @click="addSubcriteria(criteria)">ქვე-კრიტერიუმის დამატება</button>
                        </div>
                        <div class="col-sm-4 offset-4" v-if="criteria.subcriterias.length > 0">
                            <ul class="sub-criteria-container mt-3" style="list-style: none;" v-for="(subcriteria, j) of criteria.subcriterias">
                                <hr />
                                <li class="mb-2 position-relative">
                                    <input class="text form-control" type="text" placeholder="კრიტერიუმის დასახლება" v-model="subcriteria.name" />
                                    <button class="btn btn-danger btn-remove-subcriteria" @click="removeSubcriteria(criteria, j)"><i class="fa fa-ban"></i> ქვე-კრიტერიუმის წაშლა</button>
                                </li>
                                <li class="mb-2">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" :id="'sub_number'+j" type="radio" v-model="subcriteria.number_field" value="1">
                                        <label class="form-check-label" :for="'sub_number'+j">ციფრული მნიშვნელობა</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" :id="'sub_yes_no'+j" type="radio" v-model="subcriteria.number_field" value="0">
                                        <label class="form-check-label" :for="'sub_yes_no'+j">კი ან არა</label>
                                    </div>
                                </li>
                                <li class="mb-2">
                                    <div class="number-field-container" v-if="subcriteria.number_field === '1'">
                                        <input type="number" placeholder="მაქსიმალური ქულა" class="form-control" v-model="subcriteria.max_point" />
                                    </div>
                                    <div class="yes-or-no-field-container" v-if="subcriteria.number_field === '0'">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <input type="number" placeholder="კის მინშვნელობა" class="form-control" v-model="subcriteria.yes_point" />
                                            </div>
                                            <div class="col-sm-6">
                                                <input type="number" placeholder="არას მნიშვნელობა" class="form-control" v-model="subcriteria.no_point" />
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
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        name: "RateForm",

        props: {
            rateId: {
                default: null
            }
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
                            percent_in_total: '',
                            subcriterias: [{
                                name: '',
                                number_field: '1',
                                max_point: '',
                                yes_point: '',
                                no_point: ''
                            }]
                        }
                    ]
                },
                categories: []
            }
        },

        mounted() {
            this.loadProjectCategories();
        },

        methods: {
            loadProjectCategories() {
                axios.get('/api/project-categories')
                    .then(response => {
                        this.categories = response.data.data;
                    })
                    .catch(error => {
                        console.log(error.message);
                    });
            },

            removeCriteria(i) {
                this.rate.criterias.splice(i, 1);
            },

            removeSubcriteria(criteria, i) {
                criteria.subcriterias.splice(i, 1);
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
                    number_field: '1',
                    max_point: '',
                    yes_point: '',
                    no_point: ''
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