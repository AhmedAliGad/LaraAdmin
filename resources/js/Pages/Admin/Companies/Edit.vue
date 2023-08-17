<script setup>
import { Head, useForm } from "@inertiajs/vue3"
import {mdiTextBoxEditOutline, mdiArrowLeftBoldOutline, mdiUpload} from "@mdi/js"
import LayoutAuthenticated from "@/Layouts/LayoutAuthenticated.vue"
import SectionMain from "@/Components/SectionMain.vue"
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue"
import CardBox from "@/Components/CardBox.vue"
import FormField from '@/Components/FormField.vue'
import FormControl from '@/Components/FormControl.vue'
import BaseButton from '@/Components/BaseButton.vue'
import BaseButtons from '@/Components/BaseButtons.vue'
import SvgIcon from "@jamescoyle/vue-icon";
import {ref} from "vue";

const props = defineProps({
    company: {
        type: Object,
        default: () => ({}),
    },
})

const form = useForm({
    _method: 'put',
    name: props.company.name,
    image: props.company.image,
})

let fileInput = ref()
function removeFile()
{
    form.image = null
}
function selectFile()
{
    fileInput.value.click()
}
function previewSrc() {
    if (!form.image) {
        return this.removed ? false : this.file;
    }
    if (form.image instanceof Object) {
        return URL.createObjectURL(form.image);
    } else {
        return form.image;
    }

}
</script>

<template>
    <LayoutAuthenticated>
        <Head title="Update Status" />
        <SectionMain>
            <SectionTitleLineWithButton
                :icon="mdiTextBoxEditOutline"
                title="Update Status"
                main
            >
                <BaseButton
                    :route-name="route('companies.index')"
                    :icon="mdiArrowLeftBoldOutline"
                    label="Back"
                    color="white"
                    rounded-full
                    small
                />
            </SectionTitleLineWithButton>
            <CardBox
                form
                @submit.prevent="form.post(route('companies.update', props.company.id))"
            >
                <FormField
                    label="Enter Name"
                    :class="{ 'text-red-400': form.errors.name }"
                >
                    <FormControl
                        v-model="form.name"
                        type="text"
                        placeholder="Logo"
                        :error="form.errors.name"
                    >
                        <div class="text-red-400 text-sm" v-if="form.errors.name">
                            {{ form.errors.name }}
                        </div>
                    </FormControl>
                </FormField>

                <FormField
                    label="Logo"
                    :class="{ 'text-red-400': form.errors.image }"
                >
                    <div class="relative">
                        <div class="uploader-block bg-white-300 flex justify-center items-center px-3 py-2 max-w-full
                                    dark:placeholder-gray-400 dark:bg-slate-800 border-gray-700">
                            <div class="w-[320px] grid gap-2">
                                <div  @click="selectFile()" class="h-24 cursor-pointer relative flex justify-center items-center border-2 rounded-md">
                                    <svg-icon type="mdi" :path="mdiUpload"></svg-icon>
                                    <span class="bg-white dark:bg-slate-800 justify-center items-center"> Upload</span>
                                    <input hidden class="opacity-0 cursor-pointer h-full w-full" ref="fileInput"
                                           type="file" :name="form.image" accept="image/*"
                                           @input="form.image = $event.target.files[0]">
                                    <div v-show="previewSrc()" class="absolute flex justify-center items-center gap-2">
                                        <img v-show="previewSrc()" :src="previewSrc()"  class="h-20 w-30">
                                    </div>
                                </div>
                                <button type="button" v-show="previewSrc()" class="button delete-btn" @click="removeFile">Delete</button>
                            </div>
                        </div>
                    </div>
                </FormField>
                <div class="text-red-400 text-sm" v-if="form.errors.image">
                    {{ form.errors.image }}
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
