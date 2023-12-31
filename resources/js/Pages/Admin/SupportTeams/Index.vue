<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3"
import {
    mdiMonitorAccount, mdiPlus,
    mdiTrashCan, mdiAlertBoxOutline,
} from "@mdi/js"
import LayoutAuthenticated from "@/Layouts/LayoutAuthenticated.vue"
import SectionMain from "@/Components/SectionMain.vue"
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue"
import BaseButton from "@/Components/BaseButton.vue"
import CardBox from "@/Components/CardBox.vue"
import BaseButtons from "@/Components/BaseButtons.vue"
import NotificationBar from "@/Components/NotificationBar.vue"
import Pagination from "@/Components/Admin/Pagination.vue"
import Sort from "@/Components/Admin/Sort.vue"

const props = defineProps({
  users: {
    type: Object,
    default: () => ({}),
  },
  filters: {
    type: Object,
    default: () => ({}),
  },
})

const form = useForm({
  search: props.filters.search,
})

const formDelete = useForm({})

function destroy(id) {
  if (confirm("Are you sure you want to delete?")) {
    formDelete.delete(route("support_teams.destroy", id))
  }
}
</script>

<template>
  <LayoutAuthenticated>
    <Head title="Support Team" />
    <SectionMain>
      <SectionTitleLineWithButton
        :icon="mdiMonitorAccount"
        title="Support Team"
        main
      >
        <BaseButton
          :route-name="route('support_teams.create')"
          :icon="mdiPlus"
          label="Add"
          color="info"
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
      <CardBox class="mb-6" has-table>
        <form @submit.prevent="form.get(route('support_teams.index'))">
          <div class="py-2 flex">
            <div class="flex pl-4">
              <input
                type="search"
                v-model="form.search"
                class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring
                                 focus:ring-indigo-200 focus:ring-opacity-50 dark:text-blue-600"
                placeholder="Search"
              />
              <BaseButton
                label="Search"
                type="submit"
                color="info"
                class="ml-4 inline-flex items-center px-4 py-2"
              />
            </div>
          </div>
        </form>
      </CardBox>
      <CardBox class="mb-6" has-table>
        <table>
          <thead>
            <tr>
              <th>
                <Sort label="Name" attribute="name" />
              </th>
              <th>
                <Sort label="Email" attribute="email" />
              </th>
                <th>
                    <Sort label="Role" attribute="role" />
                </th>
              <th>Actions</th>
            </tr>
          </thead>

          <tbody>
            <tr v-for="user in users.data" :key="user.id">
              <td data-label="Name">
                <Link
                  :href="route('support_teams.show', user.id)"
                  class="
                    no-underline
                    hover:underline
                    text-cyan-600
                    dark:text-cyan-400
                  "
                >
                  {{ user.name }}
                </Link>
              </td>
              <td data-label="Email">
                {{ user.email }}
              </td>
                <td data-label="Role">
                    {{ user.role }}
                </td>
              <td class="before:hidden lg:w-1 whitespace-nowrap">
                <BaseButtons type="justify-start lg:justify-end" no-wrap>
                  <BaseButton
                    :route-name="route('support_teams.edit', user.id)"
                    color="info"
                    label="Edit"
                    small
                  />
                    <BaseButton
                        color="danger"
                        label="Delete"
                        small
                        @click="destroy(user.id)"
                    />
                </BaseButtons>
              </td>
            </tr>
          </tbody>
        </table>
        <div class="py-4">
          <Pagination :data="users" />
        </div>
      </CardBox>
    </SectionMain>
  </LayoutAuthenticated>
</template>
