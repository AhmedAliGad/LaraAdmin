<script setup>
import {Head, Link, usePage, router} from '@inertiajs/vue3'
import {
    mdiAccountMultiple, mdiBallot, mdiChartTimelineVariant, mdiHandshake, mdiApps, mdiLogout,
} from '@mdi/js'
import SectionMain from '@/Components/SectionMain.vue'
import CardBoxWidget from '@/Components/CardBoxWidget.vue'
import CardBox from '@/Components/CardBox.vue'
import LayoutAuthenticated from '@/Layouts/LayoutAuthenticated.vue'
import SectionTitleLineWithButton from '@/Components/SectionTitleLineWithButton.vue'
import {onMounted} from "vue";

const role = usePage().props.auth.user.role

const props = defineProps({
    tickets: {
        type: Object,
        default: () => ({}),
    },
    total_clients: {
        type: Number
    },
    total_companies: {
        type: Number
    },
    total_projects: {
        type: Number
    },
    total_tickets: {
        type: Number
    }
})
/*const logoutItem = onMounted(() => {
        router.reload({only: ['someProp']})
})*/
</script>

<template>
  <LayoutAuthenticated>
    <Head title="Dashboard" />
    <SectionMain>
      <SectionTitleLineWithButton
        :icon="mdiChartTimelineVariant"
        title="Overview"
        main
      >
      </SectionTitleLineWithButton>

      <div v-if="role == 'admin'" class="grid grid-cols-1 gap-4 lg:grid-cols-4 mb-4">
          <CardBoxWidget
          color="text-blue-500"
          :icon="mdiAccountMultiple"
          :number="total_clients"
          label="Clients"
        />
          <CardBoxWidget
          color="text-blue-500"
          :icon="mdiHandshake"
          :number="total_companies"
          label="Companies"
        />
          <CardBoxWidget
          color="text-blue-500"
          :icon="mdiApps"
          :number="total_projects"
          label="Projects"
        />
          <CardBoxWidget
              color="text-blue-500"
              :icon="mdiBallot"
              :number="total_tickets"
              label="Tickets"
          />
      </div>

      <SectionTitleLineWithButton
          :icon="mdiBallot"
          title="Latest Tickets"
      />
        <CardBox class="mb-6" has-table>
            <table>
                <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Project</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Priority</th>
                    <th>Platform</th>
                </tr>
                </thead>

                <tbody>
                <tr v-for="ticket in tickets" :key="ticket.id">
                    <td>
                        {{ ticket.id }}
                    </td>
                    <td data-label="Name">
                        <Link
                            :href="route('tickets.show', ticket.id)"
                            class=" no-underline hover:underline text-cyan-600 dark:text-cyan-400">
                            {{ ticket.title }}
                        </Link>
                    </td>
                    <td data-label="project">
                        {{ ticket.project.name }}
                    </td>
                    <td data-label="category">
                        {{ ticket.category ? ticket.category.name_en : ' - - ' }}
                    </td>
                    <td data-label="status">
                        {{ ticket.status.name_en }}
                    </td>
                    <td data-label="priority">
                        {{ ticket.priority ? ticket.priority.name_en : ' - - ' }}
                    </td>
                    <td data-label="device_os">
                        {{ ticket.device_os }}
                    </td>
                </tr>
                </tbody>
            </table>
        </CardBox>
    </SectionMain>
  </LayoutAuthenticated>
</template>
