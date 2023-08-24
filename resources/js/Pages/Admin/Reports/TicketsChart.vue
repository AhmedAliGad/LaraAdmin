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
    setting: {
        type: Object,
        default: () => ({}),
    },
    chart: Object
})

const form = useForm({
    _method: 'put',
    //name_en : props.setting.name_en,
    privacy_en : props.setting.privacy_en,
})
</script>

<template>
    <LayoutAuthenticated>
        <Head title="Tickets Chart" />
        <SectionMain>
            <SectionTitleLineWithButton
                :icon="mdiChartLine"
                title="Tickets Chart"
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

            <CardBox>
                    <div class="relative dark:placeholder-gray-400 dark:bg-slate-800 dark:text-black">
                        <apexchart :width="chart.width" :height="chart.height" :type="chart.type" :options="chart.options" :series="chart.series"
                        ></apexchart>
                    </div>
            </CardBox>
        </SectionMain>
    </LayoutAuthenticated>
</template>
