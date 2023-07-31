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
    filters: {
        type: Object,
        default: () => ({}),
    },
})

const form = useForm({
    search: props.filters.search,
    date: props.filters.date ? props.filters.date : '',
    platform: props.filters.platform ? props.filters.platform : '',
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
            <CardBox class="grid justify-items-center mb-6" has-table>
                <form @submit.prevent="form.get(route('tickets.index'))">
                    <div class="py-2 flex">
                        <div class="flex pl-4">
                            <select
                                class="h-full rounded-r border-t sm:rounded-r-none sm:border-r-0 border-r border-b block appearance-none w-auto bg-white border-gray-400 text-gray-700 py-2 px-4 pr-8 leading-tight focus:outline-none focus:border-l focus:border-r focus:bg-white focus:border-gray-500">
                                <option value="">Select Status</option>
                                <option>10</option>
                                <option>20</option>
                            </select>
                            <select
                                class="h-full rounded-r border-t sm:rounded-r-none sm:border-r-0 border-r border-b block appearance-none w-auto bg-white border-gray-400 text-gray-700 py-2 px-4 pr-8 leading-tight focus:outline-none focus:border-l focus:border-r focus:bg-white focus:border-gray-500">
                                <option value="">Select Category</option>
                                <option>10</option>
                                <option>20</option>
                            </select>
                            <select
                                class="h-full rounded-r border-t sm:rounded-r-none sm:border-r-0 border-r border-b block appearance-none w-auto bg-white border-gray-400 text-gray-700 py-2 px-4 pr-8 leading-tight focus:outline-none focus:border-l focus:border-r focus:bg-white focus:border-gray-500">
                                <option value="">Select Priority</option>
                                <option>10</option>
                                <option>20</option>
                            </select>
                            <select v-model="form.platform"
                                class="h-full rounded-r border-t sm:rounded-r-none sm:border-r-0 border-r border-b block appearance-none w-auto bg-white border-gray-400 text-gray-700 py-2 px-4 pr-8 leading-tight focus:outline-none focus:border-l focus:border-r focus:bg-white focus:border-gray-500">
                                <option value="">Select Platform</option>
                                <option value="android">Android</option>
                                <option value="ios">IOS</option>
                                <option value="web">Web</option>
                            </select>
                        </div>
                    </div>
                    <div class="py-2 flex">
                        <div class="flex pl-4">
                            <select
                                class="h-full rounded-md border-t sm:rounded-r-none sm:border-r-0 border-r border-b block appearance-none w-auto bg-white border-gray-400 text-gray-700 py-2 px-4 pr-8 leading-tight focus:outline-none focus:border-l focus:border-r focus:bg-white focus:border-gray-500">
                                <option value="">Select Project</option>
                                <option>10</option>
                                <option>20</option>
                            </select>
                            <VueCtkDateTimePicker color="#2563EB" :only-date="true" button-color="#54cc96" :inline="false"
                                                  v-model="form.date" format="YYYY-MM-DD" formatted="YYYY-MM-DD">
                            </VueCtkDateTimePicker>
                            <input
                                type="search"
                                v-model="form.search"
                                class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300
                                    focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                placeholder="Search"
                            />
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
                            <Sort label="Name" attribute="name" />
                        </th>
                        <th>
                            <Sort label="Email" attribute="email" />
                        </th>
                        <th>
                            <Sort label="Role" attribute="role" />
                        </th>
                        <th>Actions</th>
                    </tr>
                    </thead>

                    <tbody>
                    <tr v-for="user in tickets.data" :key="user.id">
                        <td data-label="Name">
                            <Link
                                :href="route('tickets.show', user.id)"
                                class="
                    no-underline
                    hover:underline
                    text-cyan-600
                    dark:text-cyan-400
                  "
                            >
                                {{ user.name }}
                            </Link>
                        </td>
                        <td data-label="Email">
                            {{ user.email }}
                        </td>
                        <td data-label="Role">
                            {{ user.role }}
                        </td>
                        <td
                            class="before:hidden lg:w-1 whitespace-nowrap"
                        >
                            <BaseButtons type="justify-start lg:justify-end" no-wrap>
                                <BaseButton
                                    :route-name="route('tickets.edit', user.id)"
                                    color="info"
                                    :icon="mdiSquareEditOutline"
                                    small
                                />
                                <BaseButton
                                    color="danger"
                                    :icon="mdiTrashCan"
                                    small
                                    @click="destroy(user.id)"
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
