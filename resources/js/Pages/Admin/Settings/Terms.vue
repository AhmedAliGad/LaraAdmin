<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3"
import { mdiCogs, mdiArrowLeftBoldOutline, mdiAlertBoxOutline } from "@mdi/js"
import LayoutAuthenticated from "@/Layouts/LayoutAuthenticated.vue"
import SectionMain from "@/Components/SectionMain.vue"
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue"
import CardBox from "@/Components/CardBox.vue"
import FormField from '@/Components/FormField.vue'
import BaseButton from '@/Components/BaseButton.vue'
import BaseButtons from '@/Components/BaseButtons.vue'
import { component as ckeditor } from '@mayasabha/ckeditor4-vue3'
import NotificationBar from "@/Components/NotificationBar.vue";

const props = defineProps({
    setting: {
        type: Object,
        default: () => ({}),
    },
})

const editorConfig = {
    language: "en",
    filebrowserImageBrowseUrl: `/laravel-filemanager?type=Images`,
    filebrowserBrowseUrl: `/laravel-filemanager?type=Files`,
}

const form = useForm({
    _method: 'put',
    //name_en : props.setting.name_en,
    terms_en : props.setting.terms_en,
})
</script>

<template>
    <LayoutAuthenticated>
        <Head title="Update Settings" />
        <SectionMain>
            <SectionTitleLineWithButton
                :icon="mdiCogs"
                title="Update Terms"
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

            <CardBox
                form
                @submit.prevent="form.post(route('settings_update'))"
            >
<!--                <FormField
                    label="Name"
                    :class="{ 'text-red-400': form.errors.name_en }"
                >
                    <FormControl
                        v-model="form.name_en"
                        type="text"
                        placeholder="Name"
                        :error="form.errors.name_en"
                    >
                        <div class="text-red-400 text-sm" v-if="form.errors.name_en">
                            {{ form.errors.name_en }}
                        </div>
                    </FormControl>
                </FormField>-->
                <FormField
                    label="Terms"
                    :class="{ 'text-red-400': form.errors.terms_en }"
                >
                    <div class="relative">
                        <ckeditor v-model="form.terms_en" :config="editorConfig"></ckeditor>
                    </div>
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
                        <BaseButton
                            :route-name="route('dashboard')"
                            label="Cancel"
                            color="white"
                        />
                    </BaseButtons>
                </template>
            </CardBox>
        </SectionMain>
    </LayoutAuthenticated>
</template>
