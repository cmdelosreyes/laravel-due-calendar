<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <calendar-form></calendar-form>
            </div>
            <div class="col-md-8">
                <calendar ref="fullCalendar">

                </calendar>
            </div>
        </div>
    </div>
</template>

<script>
    import Calendar from '../components/Calendar.vue';
    import CalendarForm from '../components/CalendarForm.vue';

    export default {
        components: {
            Calendar,
            CalendarForm,
        },
    }
</script>
