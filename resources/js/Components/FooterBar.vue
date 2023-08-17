<script setup>
import { computed } from 'vue'
import { containerMaxW } from '@/config.js';
import BaseLevel from '@/Components/BaseLevel.vue'
import JustboilLogo from '@/Components/JustboilLogo.vue'

const year = computed(() => new Date().getFullYear())
</script>

<template>
  <footer class="py-2 px-6">
    <BaseLevel :class="containerMaxW">
      <div class="text-center md:text-center">
        <b>All Rights Reserved &copy;{{ year }} |</b>
        Developed By <a
          href="https://www.fndevcs.com/index.html"
          target="_blank"
          class="text-blue-600"
        >FNDEV</a>
      </div>
      <div class="md:py-2">
      </div>
    </BaseLevel>
  </footer>
</template>
