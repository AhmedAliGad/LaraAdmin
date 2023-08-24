<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3"
import axios from "axios";
import { mdiArrowLeftBoldOutline, mdiDatabasePlus } from "@mdi/js"
import LayoutAuthenticated from "@/Layouts/LayoutAuthenticated.vue"
import SectionMain from "@/Components/SectionMain.vue"
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue"
import CardBox from "@/Components/CardBox.vue"
import FormField from '@/Components/FormField.vue'
import FormControl from '@/Components/FormControl.vue'
import BaseDivider from '@/Components/BaseDivider.vue'
import BaseButton from '@/Components/BaseButton.vue'
import BaseButtons from '@/Components/BaseButtons.vue'
import Multiselect from 'vue-multiselect'

const props = defineProps({
    companies: {
        type: Object,
        default: () => ({}),
    },
})
let projectsList = []
const form = useForm({
  name: '',
  email: '',
  phone: '',
  password: '',
  password_confirmation: '',
  role: '',
  company_id: '',
  projects: [],
  selectedProjects: [],
  projectsList:[]
})
function getProjects()
{
    axios.get(route('projects_list', {'company_id' : form.company_id}), {
        preserveScroll: true})
        .then(response => {
            form.projectsList = response.data.data
        })
}
function updateProjects() {
    let projects = [];
    form.selectedProjects.forEach((project) => {
        projects.push(project.id);
    });
    form.projects = projects;
}
</script>

<template>
  <LayoutAuthenticated>
    <Head title="Add Client" />
    <SectionMain>
      <SectionTitleLineWithButton
        :icon="mdiDatabasePlus"
        title="Add Client"
        main
      >
        <BaseButton
          :route-name="route('user.index')"
          :icon="mdiArrowLeftBoldOutline"
          label="Back"
          color="white"
          rounded-full
          small
        />
      </SectionTitleLineWithButton>
      <CardBox
        form
        @submit.prevent="form.post(route('user.store'))"
      >
        <FormField
          label="Name"
          :class="{ 'text-red-400': form.errors.name }"
        >
          <FormControl
            v-model="form.name"
            type="text"
            placeholder="Enter Name"
            :error="form.errors.name"
          >
            <div class="text-red-400 text-sm" v-if="form.errors.name">
              {{ form.errors.name }}
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
            placeholder="Enter Email"
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
                  placeholder="Enter Phone"
                  :error="form.errors.phone"
              >
                  <div class="text-red-400 text-sm" v-if="form.errors.phone">
                      {{ form.errors.phone }}
                  </div>
              </FormControl>
          </FormField>

        <FormField
          label="Password"
          :class="{ 'text-red-400': form.errors.password }"
        >
          <FormControl
            v-model="form.password"
            type="password"
            placeholder="Enter Password"
            :error="form.errors.password"
          >
            <div class="text-red-400 text-sm" v-if="form.errors.password">
              {{ form.errors.password }}
            </div>
          </FormControl>
        </FormField>
        <BaseDivider />
          <FormField
              label="Role"
              :class="{ 'text-red-400': form.errors.role }"
          >
              <div class="relative">
                  <select v-model="form.role"
                          class="px-3 py-2 max-w-full focus:ring focus:outline-none rounded w-full dark:placeholder-gray-400 h-12 border bg-white dark:bg-slate-800 border-gray-700">
                      <option value="" selected disabled>Select Role</option>
                      <option value="client">Client</option>
                      <option value="supervisor">Supervisor</option>
                  </select>
              </div>
          </FormField>
          <div class="text-red-400 text-sm" v-if="form.errors.role">
              {{ form.errors.role }}
          </div>
          <FormField
              label="Company"
              :class="{ 'text-red-400': form.errors.company_id }"
          >
              <div class="relative">
                  <select v-model="form.company_id" ref="companyID" @change="getProjects()"
                          class="px-3 py-2 max-w-full focus:ring focus:outline-none rounded w-full dark:placeholder-gray-400 h-12 border bg-white dark:bg-slate-800 border-gray-700">
                      <option value="" selected disabled>Select Company</option>
                      <option v-for="company in companies"  :value="company.id">{{ company.name }}</option>
                  </select>
              </div>
          </FormField>
          <div class="text-red-400 text-sm" v-if="form.errors.company_id">
              {{ form.errors.company_id }}
          </div>
          <FormField
              label="Projects"
              :class="{ 'text-red-400': form.errors.projects }"
          >
              <div class="relative">
                  <multiselect v-model="form.selectedProjects" :options="form.projectsList" :multiple="true" :close-on-select="false" :clear-on-select="false"
                               :preserve-search="true" placeholder="Select Project" label="name" track-by="id" :preselect-first="false"
                               @select="updateProjects()" @remove="updateProjects()"
                               class="focus:ring focus:outline-none rounded dark:placeholder-gray-400 border bg-white dark:bg-slate-800 border-gray-700"
                  >
                  </multiselect>
              </div>
          </FormField>
          <div class="text-red-400 text-sm" v-if="form.errors.projects">
              {{ form.errors.projects }}
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
<style src="vue-multiselect/dist/vue-multiselect.css"></style>
