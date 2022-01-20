<script>
import "@fullcalendar/core/vdom"; // solves problem with Vite
import FullCalendar from "@fullcalendar/vue";
import dayGridPlugin from "@fullcalendar/daygrid";
import interactionPlugin from "@fullcalendar/interaction";
import dayjs from 'dayjs';

export default {
    components: {
        FullCalendar,
    },
    data() {
        return {
            calendarOptions: {
                plugins: [dayGridPlugin, interactionPlugin],
                initialView: "dayGridMonth",
                events: this.fetchEvents,
            },
        };
    },
    methods: {
        async fetchEvents(fetchInfo) {
            var startAt = dayjs(fetchInfo.startStr).format('YYYY-MM-DD');
            var endAt = dayjs(fetchInfo.endStr).format('YYYY-MM-DD');

            var events = [];

            await this.axios
                .get('http://localhost:8000/api/calendar', {
                    params: {
                        'filter[start_at]': startAt,
                        'filter[end_at]': endAt
                    }
                })
                .then(response => {
                    events = response.data.map(function (schedule) {
                        schedule.title = schedule.event.name;
                        schedule.start = schedule.date;

                        return schedule;
                    });
                });

            return events;
        }
    },
};
</script>
<template>
    <FullCalendar ref="fullCalendar" :options="calendarOptions" />
</template>