<script setup>
import {Head, Link, usePage} from '@inertiajs/vue3'
import {mdiChartTimelineVariant, mdiArrowRight, mdiArrowLeftBoldOutline, mdiBallot} from '@mdi/js'
import SectionMain from '@/Components/SectionMain.vue'
import CardBoxWidget from '@/Components/CardBoxWidget.vue'
import LayoutAuthenticated from '@/Layouts/LayoutAuthenticated.vue'
import SectionTitleLineWithButton from '@/Components/SectionTitleLineWithButton.vue'
import CardBox from "@/Components/CardBox.vue";
import BaseButton from "@/Components/BaseButton.vue";

const role = usePage().props.auth.user.role

const props = defineProps({
    project: {
        type: Object,
        default: () => ({}),
    },
    statuses: {
        type: Object,
        default: () => ({}),
    },
    tickets: {
        type: Object,
        default: () => ({}),
    },
})
</script>

<template>
    <LayoutAuthenticated>
        <Head title="Project Tickets" />
        <SectionMain>
            <SectionTitleLineWithButton
                :icon="mdiChartTimelineVariant"
                :title="props.project.name"
                main
            >
                <BaseButton
                    :route-name="route('projects.index')"
                    :icon="mdiArrowLeftBoldOutline"
                    label="Back"
                    color="white"
                    rounded-full
                    small
                />
            </SectionTitleLineWithButton>

            <div class="grid grid-cols-1 gap-4 lg:grid-cols-3 mb-4">
                <Link :href="route('projects.show', props.project.id)" class="border-dashed">
                    <CardBoxWidget
                        color="text-blue-500"
                        :icon="mdiArrowRight"
                        :number="props.project.tickets_count"
                        label="Total"
                    />
                </Link>
                <Link v-for="(status, index) in props.statuses" :href="route('projects.show', props.project.id)"
                      :data="{'status' : status.id}">
                <CardBoxWidget
                    color="text-blue-500"
                    :icon="mdiArrowRight"
                    :number="status.counter_value"
                    :label="status.counter_name"
                />
                </Link>
            </div>

            <SectionTitleLineWithButton
                :icon="mdiBallot"
                title="Project Tickets"
            />
            <CardBox class="mb-6" has-table>
                <table>
                    <thead>
                    <tr>
                        <th>
                            #
                        </th>
                        <th>
                            Name
                        </th>
                        <th>
                            Category
                        </th>
                        <th>
                            Status
                        </th>
                        <th>
                            Priority
                        </th>
                    </tr>
                    </thead>

                    <tbody>
                    <tr v-for="ticket in props.tickets" :key="ticket.id">
                        <td>
                            {{ ticket.id }}
                        </td>
                        <td data-label="Name">
                            <Link
                                :href="route('tickets.show', ticket.id)"
                                class=" no-underline hover:underline text-cyan-600 dark:text-cyan-400">
                                {{ ticket.title }}
                            </Link>
                        </td>
                        <td data-label="category">
                            {{ ticket.category ? ticket.category.name_en : ' - - ' }}
                        </td>
                        <td data-label="status">
                            {{ ticket.status.name_en }}
                        </td>
                        <td data-label="priority">
                            {{ ticket.priority ? ticket.priority.name_en : ' - - ' }}
                        </td>
                    </tr>
                    </tbody>
                </table>
            </CardBox>
        </SectionMain>
    </LayoutAuthenticated>
</template>
