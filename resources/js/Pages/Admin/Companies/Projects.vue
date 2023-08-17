<script setup>
import {Head, Link, usePage} from '@inertiajs/vue3'
import { mdiApps, mdiArrowLeftBoldOutline } from '@mdi/js'
import SectionMain from '@/Components/SectionMain.vue'
import LayoutAuthenticated from '@/Layouts/LayoutAuthenticated.vue'
import SectionTitleLineWithButton from '@/Components/SectionTitleLineWithButton.vue'
import CardBox from "@/Components/CardBox.vue";
import BaseButton from "@/Components/BaseButton.vue";
import BaseButtons from "@/Components/BaseButtons.vue";

const role = usePage().props.auth.user.role

const props = defineProps({
    company: {
        type: Object,
        default: () => ({}),
    },
    projects: {
        type: Object,
        default: () => ({}),
    },
})
</script>

<template>
    <LayoutAuthenticated>
        <Head title="Company Projects" />
        <SectionMain>
            <SectionTitleLineWithButton
                :icon="mdiApps"
                :title="props.company.name+' Projects'"
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

            <CardBox class="mb-6" has-table>
                <table>
                    <thead>
                    <tr>
                        <th>
                            Project Name
                        </th>
                        <th>
                            Tickets no
                        </th>
                        <th>
                            Actions
                        </th>
                    </tr>
                    </thead>

                    <tbody>
                    <tr v-for="project in props.projects" :key="project.id">
                        <td data-label="Name">
                            <Link
                                :href="route('projects.show', project.id)"
                                class=" no-underline hover:underline text-cyan-600 dark:text-cyan-400">
                                {{ project.name }}
                            </Link>
                        </td>
                        <td> {{ project.tickets_count }} </td>
                        <td
                            class="before:hidden lg:w-1 whitespace-nowrap"
                        >
                            <BaseButtons type="justify-start lg:justify-end" no-wrap>
                                <BaseButton
                                    :route-name="route('projects.show', project.id)"
                                    color="warning"
                                    label="Show"
                                    small
                                />
                            </BaseButtons>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </CardBox>
        </SectionMain>
    </LayoutAuthenticated>
</template>
