<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3"
import {
    mdiCommentPlusOutline,
    mdiArrowLeftBoldOutline, mdiAlertBoxOutline
} from "@mdi/js"
import LayoutAuthenticated from "@/Layouts/LayoutAuthenticated.vue"
import SectionMain from "@/Components/SectionMain.vue"
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue"
import CardBox from "@/Components/CardBox.vue"
import FormField from '@/Components/FormField.vue'
import FormControl from '@/Components/FormControl.vue'
import BaseDivider from '@/Components/BaseDivider.vue'
import BaseButton from '@/Components/BaseButton.vue'
import BaseButtons from '@/Components/BaseButtons.vue'
import NotificationBar from "@/Components/NotificationBar.vue";

const props = defineProps({
    ticket: {
        type: Object,
        default: () => ({}),
    }
})

const form = useForm({
    comment_text: '',
    attachments: '',
})
</script>

<template>
    <LayoutAuthenticated>
        <Head title="Add Reply" />
        <SectionMain>
            <SectionTitleLineWithButton
                :icon="mdiCommentPlusOutline"
                title="Add Reply"
                main
            >
                <BaseButton
                    :route-name="route('tickets.comments.index', ticket.id)"
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
            <CardBox
                form
                @submit.prevent="form.post(route('tickets.comments.store', ticket.id))"
            >
                <FormField
                    label="Reply Body"
                    :class="{ 'text-red-400': form.errors.comment_text }"
                >
                    <FormControl
                        v-model="form.comment_text"
                        type="textarea"
                        placeholder="Enter Reply"
                        :error="form.errors.comment_text"
                    >
                        <div class="text-red-400 text-sm" v-if="form.errors.comment_text">
                            {{ form.errors.comment_text }}
                        </div>
                    </FormControl>
                </FormField>

                <BaseDivider />

                <div class="mb-3">
                    <label
                        for="formFileMultiple"
                        class="mb-2 inline-block text-neutral-700 dark:text-neutral-200"
                    >Attachments</label
                    >
                    <input
                        @input="form.attachments = $event.target.files"
                        class="relative m-0 block w-full min-w-0 flex-auto rounded border border-solid border-neutral-300 bg-clip-padding px-3 py-[0.32rem] text-base font-normal text-neutral-700 transition duration-300 ease-in-out file:-mx-3 file:-my-[0.32rem] file:overflow-hidden file:rounded-none file:border-0 file:border-solid file:border-inherit file:bg-neutral-100 file:px-3 file:py-[0.32rem] file:text-neutral-700 file:transition file:duration-150 file:ease-in-out file:[border-inline-end-width:1px] file:[margin-inline-end:0.75rem] hover:file:bg-neutral-200 focus:border-primary focus:text-neutral-700 focus:shadow-te-primary focus:outline-none dark:border-neutral-600 dark:text-neutral-200 dark:file:bg-neutral-700 dark:file:text-neutral-100 dark:focus:border-primary"
                        type="file"
                        id="formFileMultiple"
                        :name="form.attachments"
                        accept="image/*"
                        multiple />
                </div>
                <div class="text-red-400 text-sm" v-if="form.errors.attachments">
                    {{ form.errors.attachments }}
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
