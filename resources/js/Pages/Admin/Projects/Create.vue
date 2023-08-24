<script setup>
import { Head, useForm } from "@inertiajs/vue3"
import {mdiArrowLeftBoldOutline, mdiDatabasePlus} from "@mdi/js"
import LayoutAuthenticated from "@/Layouts/LayoutAuthenticated.vue"
import SectionMain from "@/Components/SectionMain.vue"
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue"
import CardBox from "@/Components/CardBox.vue"
import FormField from '@/Components/FormField.vue'
import FormControl from '@/Components/FormControl.vue'
import VueCtkDateTimePicker from 'vue-ctk-date-time-picker';
import 'vue-ctk-date-time-picker/dist/vue-ctk-date-time-picker.css';
import BaseDivider from '@/Components/BaseDivider.vue'
import BaseButton from '@/Components/BaseButton.vue'
import BaseButtons from '@/Components/BaseButtons.vue'
import FormCheckRadio from "@/Components/FormCheckRadio.vue";

const props = defineProps({
    companies: {
        type: Object,
        default: () => ({}),
    }
})

const form = useForm({
    name: '',
    company_id: '',
    start_date: '',
    end_date: '',
    active: ''
})
</script>

<template>
    <LayoutAuthenticated>
        <Head title="Add Project" />
        <SectionMain>
            <SectionTitleLineWithButton
                :icon="mdiDatabasePlus"
                title="Add Project"
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
            <CardBox
                form
                @submit.prevent="form.post(route('projects.store'))"
            >
                <FormField
                    label="Name"
                    :class="{ 'text-red-400': form.errors.name }"
                >
                    <FormControl
                        v-model="form.name"
                        type="text"
                        placeholder="Enter Name"
                        :error="form.errors.name"
                    >
                        <div class="text-red-400 text-sm" v-if="form.errors.name">
                            {{ form.errors.name }}
                        </div>
                    </FormControl>
                </FormField>
                <FormField
                    label="Company"
                    :class="{ 'text-red-400': form.errors.company_id }"
                >
                    <div class="relative">
                        <select v-model="form.company_id"
                                class="px-3 py-2 max-w-full focus:ring focus:outline-none rounded w-full dark:placeholder-gray-400 h-12 border bg-white dark:bg-slate-800 border-gray-700">
                            <option value="">All Companies</option>
                            <option v-for="company in companies"  :value="company.id">{{ company.name }}</option>
                        </select>
                    </div>
                </FormField>
                <div class="text-red-400 text-sm" v-if="form.errors.company_id">
                    {{ form.errors.company_id }}
                </div>
                <BaseDivider />
                <FormField
                    label="Support Start Date"
                    :class="{ 'text-red-400': form.errors.start_date }"
                >
                    <div class="relative">
                        <VueCtkDateTimePicker color="#2563EB" :only-date="true" button-color="#54cc96" :inline="false"
                                              v-model="form.start_date" format="YYYY-MM-DD" formatted="YYYY-MM-DD">
                        </VueCtkDateTimePicker>
                    </div>
                </FormField>
                <div class="text-red-400 text-sm" v-if="form.errors.start_date">
                    {{ form.errors.start_date }}
                </div>
                <FormField
                    label="Support End Date"
                    :class="{ 'text-red-400': form.errors.end_date }"
                >
                    <div class="relative">
                        <VueCtkDateTimePicker color="#2563EB" :only-date="true" button-color="#54cc96" :inline="false"
                                              v-model="form.end_date" format="YYYY-MM-DD" formatted="YYYY-MM-DD">
                        </VueCtkDateTimePicker>
                    </div>
                </FormField>
                <div class="text-red-400 text-sm" v-if="form.errors.end_date">
                    {{ form.errors.end_date }}
                </div>
                <FormField
                    label="Status"
                    wrap-body
                >
                    <FormCheckRadio
                        v-model="form.active"
                        type="radio"
                        label="Active"
                        name="active"
                        inputValue="1"
                    />
                    <FormCheckRadio
                        v-model="form.active"
                        type="radio"
                        label="InActive"
                        name="active"
                        inputValue="0"
                    />
                </FormField>

                <template #footer>
                    <BaseButtons>
                        <BaseButton
                            type="submit"
                            color="info"
                            label="Submit"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                        />
                    </BaseButtons>
                </template>
            </CardBox>
        </SectionMain>
    </LayoutAuthenticated>
</template>
