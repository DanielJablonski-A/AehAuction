<template>
  <div class="form-group">
    <label for="courier">Kurier:</label>
    <select id="courier" :value="courier" @change="updateCourier($event.target.value)" required>
      <option value="">Wybierz kuriera</option>
      <option v-for="courier in couriers" :key="courier['@id']" :value="courier['@id']">
        {{ courier.courierName }}
      </option>
    </select>
  </div>
</template>

<script setup>
import { ref, onMounted, defineProps, defineEmits } from 'vue';
import axios from 'axios';

// Define props and emits
const props = defineProps({
  courier: String
});
const emit = defineEmits(['update:courier']);

const couriers = ref([]);

const fetchCourier = async () => {
  try {
    const response = await axios.get('/api/couriers');
    couriers.value = response.data['hydra:member'];
  } catch (error) {
    console.error('There was an error fetching the courier:', error);
  }
};

onMounted(fetchCourier);

function updateCourier(value) {
  emit('update:courier', value);
}
</script>
