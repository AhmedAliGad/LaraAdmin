<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3"
import { mdiChartLine, mdiArrowLeftBoldOutline, mdiAlertBoxOutline } from "@mdi/js"
import LayoutAuthenticated from "@/Layouts/LayoutAuthenticated.vue"
import SectionMain from "@/Components/SectionMain.vue"
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue"
import CardBox from "@/Components/CardBox.vue"
import BaseButton from '@/Components/BaseButton.vue'
import NotificationBar from "@/Components/NotificationBar.vue";


const props = defineProps({
    filters: {
        type: Object,
        default: () => ({}),
    },
    companies: {
        type: Object,
        default: () => ({}),
    },
    chart: Object
})

const form = useForm({
    company_id : props.filters.company_id ? props.filters.company_id : '',
})
</script>

<template>
    <LayoutAuthenticated>
        <Head title="Company Chart" />
        <SectionMain>
            <SectionTitleLineWithButton
                :icon="mdiChartLine"
                title="Company Chart"
                main
            >
                <BaseButton
                    :route-name="route('dashboard')"
                    :icon="mdiArrowLeftBoldOutline"
                    label="Back"
                    color="white"
                    rounded-full
                    small
                />
            </SectionTitleLineWithButton>
            <NotificationBar
                v-if="$page.props.flash.message"
                color="success"
                :icon="mdiAlertBoxOutline"
            >
                {{ $page.props.flash.message }}
            </NotificationBar>
            <CardBox class="mb-6" has-table>
                <form @submit.prevent="form.get(route('company_chart'))">
                    <div class="flex items-center">
                        <div class="p-4 w-full">
                            <select v-model="form.company_id" @change="form.submit(form.get(route('company_chart')))"
                                    class="h-full rounded-md rounded-r border-t border-r border-b block appearance-none w-full bg-white border-gray-400 text-gray-700  leading-tight focus:outline-none focus:border-l focus:border-r focus:bg-white focus:border-gray-500">
                                <option value="" selected disabled>Select Company</option>
                                <option v-for="company in companies"  :value="company.id">{{ company.name }}</option>
                            </select>
                        </div>
                    </div>
                </form>
            </CardBox>
            <CardBox v-if="form.company_id">
                <div class="relative dark:placeholder-gray-400 dark:bg-slate-800 dark:text-black">
                    <apexchart :width="chart.width" :height="chart.height" :type="chart.type" :options="chart.options" :series="chart.series"
                    ></apexchart>
                </div>
            </CardBox>
        </SectionMain>
    </LayoutAuthenticated>
</template>
