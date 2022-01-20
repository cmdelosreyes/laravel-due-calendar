<script>
import dayjs from 'dayjs';
import toastr from 'toastr';

export default {
        mounted() {
            toastr.options.closeButton = true;
            toastr.options.closeMethod = 'fadeOut';
            toastr.options.closeDuration = 300;
            toastr.options.closeEasing = 'swing';
            toastr.options.progressBar = true;
        },
        data() {
            return {
                name: '',
                start_at: '',
                end_at: '',
                days: [],
                formErrors: {
                    days: '',
                    end_at: '',
                    name: '',
                    start_at: ''
                }
            };
        },
        computed: {
            daysList() {
                return [
                    'Sunday',
                    'Monday',
                    'Tuesday',
                    'Wednesday',
                    'Thursday',
                    'Friday',
                    'Saturday'
                ];
            }
        },
        methods: {
            submit: function() {
                this.formErrors = {
                    days: '',
                    end_at: '',
                    name: '',
                    start_at: ''
                }

                this.axios
                    .post('http://localhost:8000/api/calendar', {
                        name: this.name,
                        start_at: dayjs(this.start_at).format('YYYY-MM-DD'),
                        end_at: dayjs(this.end_at).format('YYYY-MM-DD'),
                        days: this.days
                    })
                    .then(response => {
                        toastr.success(response.data.message);
                        this.$parent.$refs.fullCalendar.$refs.fullCalendar.getApi().refetchEvents();
                    })
                    .catch(err => {
                        const formErrors = {};

                        Object.keys(err.response.data.errors).forEach(function(error) {
                            formErrors[error] = err.response.data.errors[error][0];
                        });

                        this.formErrors = formErrors;
                    })
                    .finally(() => this.loading = false)
            },
        }
    }
</script>
<template>
    <div class="card">
        <div class="card-header">Form</div>

        <div class="card-body">
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="name" :class="(formErrors.name) ? 'is-invalid' : ''">Event Name</label>
                        <input type="text" class="form-control" id="name" v-model="name" required>
                        <div class="invalid-feedback" v-if="formErrors.name">
                            {{ formErrors.name }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                        <label for="start_at" :class="(formErrors.start_at) ? 'is-invalid' : ''">From</label>
                        <vc-date-picker :popover="{visibility: 'click'}" v-model="start_at">
                            <template v-slot="{ inputValue, inputEvents }">
                                <input
                                class="form-control"
                                :value="inputValue"
                                v-on="inputEvents"
                                />
                            </template>
                        </vc-date-picker>
                        <div class="invalid-feedback" v-if="formErrors.start_at">
                            {{ formErrors.start_at }}
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                        <label for="end_at" :class="(formErrors.end_at) ? 'is-invalid' : ''">To</label>
                        <vc-date-picker :popover="{visibility: 'click'}" v-model="end_at">
                            <template v-slot="{ inputValue, inputEvents }">
                                <input
                                class="form-control"
                                :value="inputValue"
                                v-on="inputEvents"
                                />
                            </template>
                        </vc-date-picker>
                        <div class="invalid-feedback" v-if="formErrors.end_at">
                            {{ formErrors.end_at }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group" :key="value" v-for="(day, value) in daysList">
                        <input :class="(formErrors.days) ? 'form-check-input is-invalid' : 'form-check-input'" type="checkbox" :value="value" :id="day" v-model="days">
                        <label class="form-check-label" :for="day">
                            {{ day }}
                        </label>
                    </div>
                    <small class="text-danger" v-if="formErrors.days">
                        {{ formErrors.days }}
                    </small>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col">
                    <div class="d-grid sm-block">
                        <button @click="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>