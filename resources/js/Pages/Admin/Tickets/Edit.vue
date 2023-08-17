<script setup>
import { Head, useForm } from "@inertiajs/vue3"
import {
    mdiTextBoxEditOutline,
    mdiArrowLeftBoldOutline
} from "@mdi/js"
import LayoutAuthenticated from "@/Layouts/LayoutAuthenticated.vue"
import SectionMain from "@/Components/SectionMain.vue"
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue"
import CardBox from "@/Components/CardBox.vue"
import FormField from '@/Components/FormField.vue'
import BaseButton from '@/Components/BaseButton.vue'
import BaseButtons from '@/Components/BaseButtons.vue'

const props = defineProps({
    ticket: {
        type: Object,
        default: () => ({}),
    },
    projects: {
        type: Object,
        default: () => ({}),
    },
    statuses: {
        type: Object,
        default: () => ({}),
    },
    categories: {
        type: Object,
        default: () => ({}),
    },
    priorities: {
        type: Object,
        default: () => ({}),
    },
})

const form = useForm({
    _method: 'put',
    title: props.ticket.title,
    project_id: props.ticket.project_id,
    ticket_category_id: props.ticket.ticket_category_id,
    status_id: props.ticket.status_id,
    priority_id: props.ticket.priority_id,
})
</script>

<template>
    <LayoutAuthenticated>
        <Head title="Update Ticket" />
        <SectionMain>
            <SectionTitleLineWithButton
                :icon="mdiTextBoxEditOutline"
                title="Update Ticket"
                main
            >
                <BaseButton
                    :route-name="route('tickets.index')"
                    :icon="mdiArrowLeftBoldOutline"
                    label="Back"
                    color="white"
                    rounded-full
                    small
                />
            </SectionTitleLineWithButton>
            <CardBox
                form
                @submit.prevent="form.post(route('tickets.update', props.ticket.id))"
            >
                <FormField
                    label="Project"
                    :class="{ 'text-red-400': form.errors.project_id }"
                >
                    <div class="relative">
                    <select v-model="form.project_id"
                            class="px-3 py-2 max-w-full focus:ring focus:outline-none rounded w-full dark:placeholder-gray-400 h-12 border bg-white dark:bg-slate-800 border-gray-700">
                        <option value="">All Projects</option>
                        <option v-for="project in projects"  :value="project.id">{{ project.name }}</option>
                    </select>
                    </div>
                </FormField>
                <div class="text-red-400 text-sm" v-if="form.errors.project_id">
                    {{ form.errors.project_id }}
                </div>

                <FormField
                    label="Type"
                    :class="{ 'text-red-400': form.errors.ticket_category_id }"
                >
                    <div class="relative">
                    <select v-model="form.ticket_category_id"
                            class="px-3 py-2 max-w-full focus:ring focus:outline-none rounded w-full dark:placeholder-gray-400 h-12 border bg-white dark:bg-slate-800 border-gray-700">
                        <option value="">All Categories</option>
                        <option v-for="category in categories"  :value="category.id">{{ category.name_en }}</option>
                    </select>
                    </div>
                </FormField>
                <div class="text-red-400 text-sm" v-if="form.errors.ticket_category_id">
                    {{ form.errors.ticket_category_id }}
                </div>

                <FormField
                    label="Priority"
                    :class="{ 'text-red-400': form.errors.priority_id }"
                >
                    <div class="relative">
                    <select v-model="form.priority_id"
                            class="px-3 py-2 max-w-full focus:ring focus:outline-none rounded w-full dark:placeholder-gray-400 h-12 border bg-white dark:bg-slate-800 border-gray-700">
                        <option value="">All Projects</option>
                        <option v-for="priority in priorities"  :value="priority.id">{{ priority.name_en }}</option>
                    </select>
                    </div>
                </FormField>
                <div class="text-red-400 text-sm" v-if="form.errors.priority_id">
                    {{ form.errors.priority_id }}
                </div>

                <FormField
                    label="Status"
                    :class="{ 'text-red-400': form.errors.status_id }"
                >
                    <div class="relative">
                    <select v-model="form.status_id"
                            class="px-3 py-2 max-w-full focus:ring focus:outline-none rounded w-full dark:placeholder-gray-400 h-12 border bg-white dark:bg-slate-800 border-gray-700">
                        <option value="">All Projects</option>
                        <option v-for="status in statuses"  :value="status.id">{{ status.name_en }}</option>
                    </select>
                    </div>
                </FormField>
                <div class="text-red-400 text-sm" v-if="form.errors.status_id">
                    {{ form.errors.status_id }}
                </div>

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
