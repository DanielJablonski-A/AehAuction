<template>
  <PageTop></PageTop>
  <div class="background flex flex-col">
    <div class="border-bottom flex-auto flex flex-col sm:flex-row justify-center px-8">
      <div class="sm:ml-3 sm:w-1/2 md:w-2/3">
        <div id="mainView" class="py-3">
          <AuctionsList></AuctionsList>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, provide } from 'vue';
import AuctionsList from './AuctionsList.vue';
import PageTop from "./PageTop.vue";

// Using defineProps to define incoming props
const props = defineProps({
  entrypoint: String,
  user: Object,
  tokens: [String, Array, Object]
});

// Using reactive references directly
const user = ref(props.user);
const tokens = ref(props.tokens);
provide('tokens', tokens);
</script>
