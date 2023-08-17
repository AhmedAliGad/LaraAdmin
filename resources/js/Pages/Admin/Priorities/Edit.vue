<script setup>
import { Head, useForm } from "@inertiajs/vue3"
import { mdiTextBoxEditOutline, mdiArrowLeftBoldOutline } from "@mdi/js"
import LayoutAuthenticated from "@/Layouts/LayoutAuthenticated.vue"
import SectionMain from "@/Components/SectionMain.vue"
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue"
import CardBox from "@/Components/CardBox.vue"
import FormField from '@/Components/FormField.vue'
import FormControl from '@/Components/FormControl.vue'
import BaseButton from '@/Components/BaseButton.vue'
import BaseButtons from '@/Components/BaseButtons.vue'

const props = defineProps({
    priority: {
        type: Object,
        default: () => ({}),
    },
})

const form = useForm({
    _method: 'put',
    name_en: props.priority.name_en,
})
</script>

<template>
    <LayoutAuthenticated>
        <Head title="Update Priority" />
        <SectionMain>
            <SectionTitleLineWithButton
                :icon="mdiTextBoxEditOutline"
                title="Update Priority"
                main
            >
                <BaseButton
                    :route-name="route('priorities.index')"
                    :icon="mdiArrowLeftBoldOutline"
                    label="Back"
                    color="white"
                    rounded-full
                    small
                />
            </SectionTitleLineWithButton>
            <CardBox
                form
                @submit.prevent="form.post(route('priorities.update', props.priority.id))"
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
