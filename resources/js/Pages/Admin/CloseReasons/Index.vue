<script setup>
import { Head, useForm } from "@inertiajs/vue3"
import {
    mdiPlus, mdiSquareEditOutline,
    mdiAlertBoxOutline, mdiCloseBoxMultiple,
} from "@mdi/js"
import LayoutAuthenticated from "@/Layouts/LayoutAuthenticated.vue"
import SectionMain from "@/Components/SectionMain.vue"
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue"
import BaseButton from "@/Components/BaseButton.vue"
import CardBox from "@/Components/CardBox.vue"
import BaseButtons from "@/Components/BaseButtons.vue"
import NotificationBar from "@/Components/NotificationBar.vue"
import Pagination from "@/Components/Admin/Pagination.vue"
import Sort from "@/Components/Admin/Sort.vue"

const props = defineProps({
    close_reasons: {
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
})

const formDelete = useForm({})

function destroy(id) {
    if (confirm("Are you sure you want to delete?")) {
        formDelete.delete(route("close_reasons.destroy", id))
    }
}
</script>

<template>
    <LayoutAuthenticated>
        <Head title="Close Reasons" />
        <SectionMain>
            <SectionTitleLineWithButton
                :icon="mdiCloseBoxMultiple"
                title="Close Reasons"
                main
            >
                <BaseButton
                    :route-name="route('close_reasons.create')"
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
                <form @submit.prevent="form.get(route('close_reasons.index'))">
                    <div class="py-2 flex">
                        <div class="flex pl-4">
                            <input
                                type="search"
                                v-model="form.search"
                                class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring
                                 focus:ring-indigo-200 focus:ring-opacity-50"
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
                            <Sort label="Name" attribute="title_en" />
                        </th>
                        <th>Actions</th>
                    </tr>
                    </thead>

                    <tbody>
                    <tr v-for="priority in close_reasons.data" :key="priority.id">
                        <td data-label="Name">
                            {{ priority.title_en }}
                        </td>
                        <td
                            class="before:hidden lg:w-1 whitespace-nowrap"
                        >
                            <BaseButtons type="justify-start lg:justify-center" no-wrap>
                                <BaseButton
                                    :route-name="route('close_reasons.edit', priority.id)"
                                    color="info"
                                    :icon="mdiSquareEditOutline"
                                    small
                                />
                            </BaseButtons>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="py-4">
                    <Pagination :data="close_reasons" />
                </div>
            </CardBox>
        </SectionMain>
    </LayoutAuthenticated>
</template>
