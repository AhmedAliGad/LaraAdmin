<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3"
import {
    mdiCogs,
    mdiArrowLeftBoldOutline
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
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";

const props = defineProps({
    setting: {
        type: Object,
        default: () => ({}),
    },
})

const form = useForm({
    _method: 'put',
    name_en : props.setting.name_en,
    email: props.setting.email,
    terms_en : props.setting.terms_en
})
</script>

<template>
    <LayoutAuthenticated>
        <Head title="Update Settings" />
        <SectionMain>
            <SectionTitleLineWithButton
                :icon="mdiCogs"
                title="Update Settings"
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
            <CardBox
                form
                @submit.prevent="form.post(route('settings_update'))"
            >
                <FormField
                    label="Enter Name"
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
                </FormField>

                <FormField
                    label="Enter Email"
                    :class="{ 'text-red-400': form.errors.email }"
                >
                    <FormControl
                        v-model="form.email"
                        type="text"
                        placeholder="Email"
                        :error="form.errors.email"
                    >
                        <div class="text-red-400 text-sm" v-if="form.errors.email">
                            {{ form.errors.email }}
                        </div>
                    </FormControl>
                </FormField>
                <ckeditor
                    id="editor"
                    :editor="ClassicEditor"
                    v-model="form.terms_en"
                    :config="editorConfig"
                ></ckeditor>
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
