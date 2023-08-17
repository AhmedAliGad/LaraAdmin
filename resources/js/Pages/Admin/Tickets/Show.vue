<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3"
import {
    mdiTimelineClockOutline,
  mdiArrowLeftBoldOutline,
} from "@mdi/js"
import LayoutAuthenticated from "@/Layouts/LayoutAuthenticated.vue"
import SectionMain from "@/Components/SectionMain.vue"
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue"
import CardBox from "@/Components/CardBox.vue"
import BaseButton from "@/Components/BaseButton.vue"

const props = defineProps({
  ticket: {
    type: Object,
    default: () => ({}),
  },
    activities: {
    type: Object,
    default: () => ({}),
  },
})
</script>

<template>
  <LayoutAuthenticated>
    <Head title="Ticket Log" />
    <SectionMain>
      <SectionTitleLineWithButton
        :icon="mdiTimelineClockOutline"
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
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
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
        <CardBox class="mb-6">
            <ol class="relative border-l border-gray-200 dark:border-gray-700">
                <li class="mb-10 ml-4" v-for="log in activities" :key="log.id">
                    <div class="absolute w-3 h-3 bg-gray-200 rounded-full mt-1.5 -left-1.5 border border-white dark:border-gray-900 dark:bg-gray-700"></div>
                    <time class="mb-1 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">{{  new Date(log.created_at).toLocaleString() }}</time>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ log.causer ? log.causer.name : ' - - ' }}</h3>
                    <div v-if="log.event == 'created'">
                        <p class="mb-4 text-base font-normal text-gray-500 dark:text-gray-400">
                            created ticket.</p>
                    </div>
                    <div v-else-if="log.event == 'updated'">
                        <p v-for="(change, key) in  log.properties['attributes']" class="mb-4 text-base font-normal text-gray-500 dark:text-gray-400">
                            Update {{ key.substring(0, key.indexOf('_id')) }}.</p>
                    </div>
                </li>
            </ol>
        </CardBox>
    </SectionMain>
  </LayoutAuthenticated>
</template>
