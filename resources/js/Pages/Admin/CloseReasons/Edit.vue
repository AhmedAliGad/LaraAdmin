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
    closeReason: {
        type: Object,
        default: () => ({}),
    },
})

const form = useForm({
    _method: 'put',
    title_en: props.closeReason.title_en,
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
                    :route-name="route('close_reasons.index')"
                    :icon="mdiArrowLeftBoldOutline"
                    label="Back"
                    color="white"
                    rounded-full
                    small
                />
            </SectionTitleLineWithButton>
            <CardBox
                form
                @submit.prevent="form.post(route('close_reasons.update', props.closeReason.id))"
            >
                <FormField
                    label="Enter Name"
                    :class="{ 'text-red-400': form.errors.title_en }"
                >
                    <FormControl
                        v-model="form.title_en"
                        type="text"
                        placeholder="Name"
                        :error="form.errors.title_en"
                    >
                        <div class="text-red-400 text-sm" v-if="form.errors.title_en">
                            {{ form.errors.title_en }}
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
