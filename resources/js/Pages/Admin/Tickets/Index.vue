<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3"
import {
    mdiPlus,
    mdiSquareEditOutline,
    mdiTrashCan,
    mdiAlertBoxOutline, mdiBallot,
} from "@mdi/js"
import LayoutAuthenticated from "@/Layouts/LayoutAuthenticated.vue"
import SectionMain from "@/Components/SectionMain.vue"
import VueCtkDateTimePicker from 'vue-ctk-date-time-picker';
import 'vue-ctk-date-time-picker/dist/vue-ctk-date-time-picker.css';
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue"
import BaseButton from "@/Components/BaseButton.vue"
import CardBox from "@/Components/CardBox.vue"
import BaseButtons from "@/Components/BaseButtons.vue"
import NotificationBar from "@/Components/NotificationBar.vue"
import Pagination from "@/Components/Admin/Pagination.vue"
import Sort from "@/Components/Admin/Sort.vue"

const props = defineProps({
    tickets: {
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
    projects: {
        type: Object,
        default: () => ({}),
    },
    filters: {
        type: Object,
        default: () => ({}),
    },
})

const form = useForm({
    search: props.filters.search,
    date: props.filters.date ? props.filters.date : '',
    platform: props.filters.platform ? props.filters.platform : '',
    status_id : props.filters.status_id ? props.filters.status_id : '',
    category_id : props.filters.category_id ? props.filters.category_id : '',
    priority_id : props.filters.priority_id ? props.filters.priority_id : '',
    project_id : props.filters.project_id ? props.filters.project_id : '',
})

const formDelete = useForm({})

function destroy(id) {
    if (confirm("Are you sure you want to delete?")) {
        formDelete.delete(route("tickets.destroy", id))
    }
}
</script>

<template>
    <LayoutAuthenticated>
        <Head title="Tickets" />
        <SectionMain>
            <SectionTitleLineWithButton
                :icon="mdiBallot"
                title="Tickets"
                main
            >
                <BaseButton
                    :route-name="route('tickets.create')"
                    :icon="mdiPlus"
                    label="Add"
                    color="info"
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
                <form @submit.prevent="form.get(route('tickets.index'))">
                    <div class="flex items-stretch">
                        <div class="p-4 w-full">
                            <select v-model="form.status_id"
                                class="h-full rounded-md rounded-r border-t border-r border-b block appearance-none w-full bg-white border-gray-400 text-gray-700  leading-tight focus:outline-none focus:border-l focus:border-r focus:bg-white focus:border-gray-500">
                                <option value="">Select Status</option>
                                <option v-for="status in statuses"  :value="status.id">{{ status.name_en }}</option>
                            </select>
                        </div>
                        <div class="p-4 w-full">
                            <select v-model="form.category_id"
                                class="h-full rounded-md rounded-r border-t border-r border-b block appearance-none w-full bg-white border-gray-400 text-gray-700  leading-tight focus:outline-none focus:border-l focus:border-r focus:bg-white focus:border-gray-500">
                                <option value="">Select Category</option>
                                <option v-for="category in categories"  :value="category.id">{{ category.name_en }}</option>
                            </select>
                        </div>
                        <div class="p-4 w-full">
                            <select v-model="form.priority_id"
                                class="h-full rounded-md rounded-r border-t border-r border-b block appearance-none w-full bg-white border-gray-400 text-gray-700  leading-tight focus:outline-none focus:border-l focus:border-r focus:bg-white focus:border-gray-500">
                                <option value="">Select Priority</option>
                                <option v-for="priority in priorities"  :value="priority.id">{{ priority.name_en }}</option>
                            </select>
                        </div>
                        <div class="p-4 w-full">
                            <select v-model="form.platform"
                                class="h-full rounded-md rounded-r border-t border-r border-b block appearance-none w-full bg-white border-gray-400 text-gray-700  leading-tight focus:outline-none focus:border-l focus:border-r focus:bg-white focus:border-gray-500">
                                <option value="">Select Platform</option>
                                <option value="android">Android</option>
                                <option value="ios">IOS</option>
                                <option value="web">Web</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex items-stretch">
                        <div class="p-4 w-full">
                            <select v-model="form.project_id"
                                class="h-full rounded-md border-t border-r border-b block appearance-none w-full bg-white border-gray-400 text-gray-700 leading-tight focus:outline-none focus:border-l focus:border-r focus:bg-white focus:border-gray-500">
                                <option value="">Select Project</option>
                                <option v-for="project in projects"  :value="project.id">{{ project.name }}</option>
                            </select>
                        </div>
                        <div class="p-4 w-full">
                            <VueCtkDateTimePicker color="#2563EB" :only-date="true" button-color="#54cc96" :inline="false"
                                                  v-model="form.date" format="YYYY-MM-DD" formatted="YYYY-MM-DD">
                            </VueCtkDateTimePicker>
                        </div>
                        <div class="p-4 w-full">
                            <input
                                type="search"
                                v-model="form.search"
                                class="rounded-md shadow-sm border-gray-400 w-full focus:border-indigo-400
                                    focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                placeholder="Search"
                            />
                        </div>
                        <div class="p-4 w-full">
                            <BaseButton
                                label="Search"
                                type="submit"
                                color="info"
                                class="ml-4 inline-flex items-center px-4 py-2"
                            />
                        </div>
                    </div>
                </form>
            </CardBox>
            <CardBox class="mb-6" has-table>
                <table>
                    <thead>
                    <tr>
                        <th>
                           #
                        </th>
                        <th>
                            <Sort label="Name" attribute="name" />
                        </th>
                        <th>
                            <Sort label="Project" attribute="email" />
                        </th>
                        <th>
                            <Sort label="Category" attribute="role" />
                        </th>
                        <th>
                            <Sort label="Status" attribute="role" />
                        </th>
                        <th>
                            <Sort label="Priority" attribute="role" />
                        </th>
                        <th>
                            <Sort label="Platform" attribute="platform" />
                        </th>
                        <th>Actions</th>
                    </tr>
                    </thead>

                    <tbody>
                    <tr v-for="ticket in tickets.data" :key="ticket.id">
                        <td>
                            {{ ticket.id }}
                        </td>
                        <td data-label="Name">
                            <Link
                                :href="route('tickets.show', ticket.id)"
                                class="
                    no-underline
                    hover:underline
                    text-cyan-600
                    dark:text-cyan-400
                  "
                            >
                                {{ ticket.name }}
                            </Link>
                        </td>
                        <td data-label="Email">
                            {{ ticket.email }}
                        </td>
                        <td data-label="Role">
                            {{ ticket.role }}
                        </td>
                        <td
                            class="before:hidden lg:w-1 whitespace-nowrap"
                        >
                            <BaseButtons type="justify-start lg:justify-end" no-wrap>
                                <BaseButton
                                    :route-name="route('tickets.edit', ticket.id)"
                                    color="info"
                                    :icon="mdiSquareEditOutline"
                                    small
                                />
                                <BaseButton
                                    color="danger"
                                    :icon="mdiTrashCan"
                                    small
                                    @click="destroy(ticket.id)"
                                />
                            </BaseButtons>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="py-4">
                    <Pagination :data="tickets" />
                </div>
            </CardBox>
        </SectionMain>
    </LayoutAuthenticated>
</template>
