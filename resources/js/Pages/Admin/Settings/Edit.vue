<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3"
import {mdiCogs, mdiArrowLeftBoldOutline, mdiAlertBoxOutline} from "@mdi/js"
import LayoutAuthenticated from "@/Layouts/LayoutAuthenticated.vue"
import SectionMain from "@/Components/SectionMain.vue"
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue"
import CardBox from "@/Components/CardBox.vue"
import FormField from '@/Components/FormField.vue'
import FormControl from '@/Components/FormControl.vue'
import BaseButton from '@/Components/BaseButton.vue'
import BaseButtons from '@/Components/BaseButtons.vue'
import NotificationBar from "@/Components/NotificationBar.vue";

const props = defineProps({
    setting: {
        type: Object,
        default: () => ({}),
    },
    types : {
        type: Object,
        default: () => ({}),
    }
})
function addField() {
    form.social_links.push({social_type : '', social_link : ''});
}
function removeField() {
    //form.social_links = form.social_links.filter(obj => obj.id !== id);
    if (form.social_links.length > 0) {
        form.social_links.pop();
    }
}
const form = useForm({
    _method: 'put',
    name_en : props.setting.name_en,
    email: props.setting.email,
    phone: props.setting.phone,
    description_en : props.setting.description_en,
    social_links : props.setting.social_links ? props.setting.social_links : [{ social_link: '', social_type: '' }],
    types: props.types
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
                <FormField
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
                </FormField>
                <FormField
                    label="Description"
                    :class="{ 'text-red-400': form.errors.description_en }"
                >
                    <FormControl
                        v-model="form.description_en"
                        type="textarea"
                        placeholder="Description"
                        :error="form.errors.description_en"
                    >
                        <div class="text-red-400 text-sm" v-if="form.errors.description_en">
                            {{ form.errors.description_en }}
                        </div>
                    </FormControl>
                </FormField>
                <FormField
                    label="Email"
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
                <FormField
                    label="Phone"
                    :class="{ 'text-red-400': form.errors.phone }"
                >
                    <FormControl
                        v-model="form.phone"
                        type="text"
                        placeholder="Phone"
                        :error="form.errors.phone"
                    >
                        <div class="text-red-400 text-sm" v-if="form.errors.phone">
                            {{ form.errors.phone }}
                        </div>
                    </FormControl>
                </FormField>
                <div class="items-stretch">
                    <p class="block font-bold mb-2">Social Media Links</p>
                    <div class="border p-2 w-full" v-for="(field, index) in form.social_links" :key="index">
                        <FormField
                            label="Social Link"
                            :class="{ 'text-red-400': form.errors.description_en }"
                        >
                            <select class="px-3 py-2 max-w-full focus:ring focus:outline-none rounded w-full dark:placeholder-gray-400 h-12 border bg-white dark:bg-slate-800 border-gray-700"
                                v-model="field.social_type"
                            >
                                <option value="">Select Type</option>
                                <option :selected="type.title == field.social_type"
                                    v-for="(type, index) in form.types"
                                    :key="index"
                                    :value="type.title">{{ type.title }}</option>
                            </select>
                            <FormControl
                                v-model="field.social_link"
                                type="text"
                                placeholder="Enter Link"
                            ></FormControl>
                        </FormField>

                        <button type="button"
                            class="font-bold text-red-400 text-xs w-full text-right mb-2 focus:outline-none"
                            @click="removeField()"
                        >
                            &mdash; Remove
                        </button>
                    </div>

                    <button type="button" @click="addField()"
                        class="mb-2 mt-2 text-blue-500 font-bold focus:outline-none"
                    >
                        + Add
                    </button>
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
