<script setup>
import {Head, useForm} from "@inertiajs/vue3"
import {
    mdiMessageReplyText, mdiArrowLeftBoldOutline, mdiInformationBox, mdiAlertBoxOutline
} from "@mdi/js"
import LayoutAuthenticated from "@/Layouts/LayoutAuthenticated.vue"
import SectionMain from "@/Components/SectionMain.vue"
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue"
import CardBox from "@/Components/CardBox.vue"
import BaseButton from "@/Components/BaseButton.vue"
import BaseDivider from "@/Components/BaseDivider.vue";
import NotificationBar from "@/Components/NotificationBar.vue";
import { VueCollapsiblePanelGroup, VueCollapsiblePanel } from '@dafcoe/vue-collapsible-panel'
import '@dafcoe/vue-collapsible-panel/dist/vue-collapsible-panel.css'

const props = defineProps({
    ticket: {
        type: Object,
        default: () => ({}),
    },
    comments: {
        type: Object,
        default: () => ({}),
    },
})
const form = useForm({
    attachments: null,
    comment_text: ''
})
</script>

<template>
    <LayoutAuthenticated>
        <Head title="Ticket Replies" />
        <SectionMain>
            <SectionTitleLineWithButton
                :icon="mdiInformationBox"
                :title="ticket.title"
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
            <NotificationBar
                v-if="$page.props.flash.message"
                color="success"
                :icon="mdiAlertBoxOutline"
            >
                {{ $page.props.flash.message }}
            </NotificationBar>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-2 mb-6">
                <CardBox class="mb-6">
                    <table>
                        <tbody>
                        <tr>
                            <td class="p-4 pl-8 text-slate-500 dark:text-slate-400 hidden lg:block">
                                Project Name
                            </td>
                            <td data-label="Project">
                                {{ ticket.project ? ticket.project.name : ' - - ' }}
                            </td>
                        </tr>
                        <tr>
                            <td class="p-4 pl-8 text-slate-500 dark:text-slate-400 hidden lg:block">
                                Ticket Priority
                            </td>
                            <td data-label="Priority">
                                {{ ticket.priority ? ticket.priority.name_en : ' - - ' }}
                            </td>
                        </tr>
                        <tr>
                            <td class="p-4 pl-8 text-slate-500 dark:text-slate-400 hidden lg:block">
                                Ticket Category
                            </td>
                            <td data-label="Category">
                                {{ ticket.category ? ticket.category.name_en : ' - - ' }}
                            </td>
                        </tr>
                        <tr>
                            <td class="p-4 pl-8 text-slate-500 dark:text-slate-400 hidden lg:block">
                                Ticket Status
                            </td>
                            <td data-label="Status">
                                {{ ticket.status ? ticket.status.name_en : ' - - ' }}
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </CardBox>
                <CardBox class="mb-6">
                    <table>
                        <tbody>
                        <tr>
                            <td class="p-4 pl-8 text-slate-500 dark:text-slate-400 hidden lg:block">
                                Created By
                            </td>
                            <td data-label="Name">
                                {{ ticket.created_by ? ticket.created_by.name : ' - - ' }}
                            </td>
                        </tr>
                        <tr>
                            <td class="p-4 pl-8 text-slate-500 dark:text-slate-400 hidden lg:block">
                                Created
                            </td>
                            <td data-label="Created">
                                {{ new Date(ticket.created_at).toLocaleString() }}
                            </td>
                        </tr>
                        <tr>
                            <td class="p-4 pl-8 text-slate-500 dark:text-slate-400 hidden lg:block">
                                Name
                            </td>
                            <td data-label="Name">
                                {{ ticket.title }}
                            </td>
                        </tr>
                        <tr>
                            <td class="p-4 pl-8 text-slate-500 dark:text-slate-400 hidden lg:block">
                                Content
                            </td>
                            <td data-label="Content">
                                {{ ticket.content }}
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </CardBox>
            </div>
            <BaseDivider></BaseDivider>
            <SectionTitleLineWithButton
                :icon="mdiMessageReplyText"
                :title="ticket.title+' Replies'"
                main
            ></SectionTitleLineWithButton>
            <vue-collapsible-panel-group accordion v-for="(comment, index) in comments" :id="comment.id">
                <vue-collapsible-panel :expanded="index === 0" class="px-5 py-4 rounded-t-lg border-neutral-200 bg-white dark:border-neutral-600 dark:bg-slate-900/70 dark:text-gray-700">
                    <template #title>
                        {{  comment.user.name +' ( '+ comment.user.role +' )' }}
                    </template>
                    <template #content class="px-5 py-4 bg-gray-50">
                        <div v-if="comment.attachments.length > 0" class="grid grid-cols-1 lg:grid-cols-2 gap-2">
                            <div class="mb-2 mt-2">
                                <label class="text-xl leading-tight">Reply Time</label>
                                <div class="px-5 py-4 bg-gray-200">
                                    {{ new Date(comment.created_at).toLocaleString()}}
                                </div>
                                <label class="text-xl leading-tight">Reply Body</label>
                                <div class="px-5 py-4 bg-gray-200">
                                    {{ comment.comment_text}}
                                </div>
                            </div>
                            <div class="mb-2 mt-2">
                                <label>Attachments</label>
                                <div v-for="attachment in comment.attachments" class="px-5 py-4 bg-gray-200">
                                    <a target="_blank" :href="attachment.file_path">{{ attachment.file_name+'.'+attachment.type }}</a>
                                    <hr />
                                </div>
                            </div>
                        </div>
                        <div v-else >
                            <div class="mb-2 mt-2">
                                <label class="text-xl leading-tight">Reply Time </label>
                                <div class="px-5 py-4 bg-gray-200">
                                    {{ new Date(comment.created_at).toLocaleString()}}
                                </div>
                                <label class="text-xl leading-tight">Reply Body </label>
                                <div class="px-5 py-4 bg-gray-200">
                                    {{ comment.comment_text}}
                                </div>
                            </div>
                        </div>
                    </template>
                </vue-collapsible-panel>
            </vue-collapsible-panel-group>
            <BaseDivider></BaseDivider>
            <BaseButton v-if="ticket.status_id != 4"
                :route-name="route('tickets.comments.create', ticket.id)"
                color="info"
                label="Add Reply"
                small
            />
        </SectionMain>
    </LayoutAuthenticated>
</template>
