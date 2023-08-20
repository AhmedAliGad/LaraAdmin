<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3"
import { mdiCogs, mdiArrowLeftBoldOutline, mdiAlertBoxOutline } from "@mdi/js"
import LayoutAuthenticated from "@/Layouts/LayoutAuthenticated.vue"
import SectionMain from "@/Components/SectionMain.vue"
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue"
import CardBox from "@/Components/CardBox.vue"
import FormField from '@/Components/FormField.vue'
import BaseButton from '@/Components/BaseButton.vue'
import BaseButtons from '@/Components/BaseButtons.vue'
import NotificationBar from "@/Components/NotificationBar.vue";

const props = defineProps({
    setting: {
        type: Object,
        default: () => ({}),
    },
})

import "leaflet/dist/leaflet.css";
import { LMap, LTileLayer, LMarker, LControlLayers, LPopup } from "@vue-leaflet/vue-leaflet";
import FormControl from "@/Components/FormControl.vue";
const zoom = 5;
const form = useForm({
    _method: 'put',
    address_en : props.setting.address_en,
    latitude : props.setting.latitude,
    longitude : props.setting.longitude,
})
function handleClick(a) {
    form.latitude = parseFloat(a.target._latlng.lat);
    form.longitude = parseFloat(a.target._latlng.lng);
}
</script>

<template>
    <LayoutAuthenticated>
        <Head title="Update Address" />
        <SectionMain>
            <SectionTitleLineWithButton
                :icon="mdiCogs"
                title="Update Address"
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
                    label="Enter Address"
                    :class="{ 'text-red-400': form.errors.address_en }"
                >
                    <FormControl
                        v-model="form.address_en"
                        type="text"
                        placeholder="Address"
                        :error="form.errors.address_en"
                    >
                        <div class="text-red-400 text-sm" v-if="form.errors.address_en">
                            {{ form.errors.address_en }}
                        </div>
                    </FormControl>
                </FormField>
                <FormField
                    label="Location"
                    :class="{ 'text-red-400': form.errors.terms_en }"
                >
                    <div class="relative">
                        <div style="height: 50vh; width: 55vw;">
                            <l-map ref="map" v-model:zoom="zoom" :center="[26.8206, 30.8025]" :use-global-leaflet="false">
                                <l-tile-layer
                                    url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
                                    layer-type="base"
                                    name="OpenStreetMap"
                                ></l-tile-layer>
                                <l-control-layers />
                             <l-marker :lat-lng="[form.latitude ? form.latitude : 23.4241, form.longitude ? form.longitude : 53.8478]"
                                       draggable @moveend="handleClick($event)">
                                 <l-popup>
                                     {{ form.address_en }}
                                 </l-popup>
                             </l-marker>
<!--                                <div v-for="item in setting.social_links">
                                <l-marker :lat-lng="[item.lat, item.lng]">
                                    <l-popup>
                                        Test Address
                                    </l-popup>
                                </l-marker>
                                </div>-->
                            </l-map>
                        </div>
                    </div>
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
