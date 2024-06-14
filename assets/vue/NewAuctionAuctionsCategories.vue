<template>
  <div class="form-group">
    <label for="auctionCategory">Kategoria:</label>
    <select id="auctionCategory" :value="auctionCategory" @change="updateCategory($event.target.value)" required>
      <option value="">Wybierz kategorie</option>
      <option v-for="category in categories" :key="category['@id']" :value="category['@id']">
        {{ category.categoryName }}
      </option>
    </select>
  </div>
</template>

<script setup>
import { ref, onMounted, defineProps, defineEmits } from 'vue';
import axios from 'axios';

// Define props and emits
const props = defineProps({
  auctionCategory: String
});
const emit = defineEmits(['update:category']);

const categories = ref([]);

const fetchCategories = async () => {
  try {
    const response = await axios.get('/api/auctions_categories');
    categories.value = response.data['hydra:member'];
  } catch (error) {
    console.error('There was an error fetching the categories:', error);
  }
};

onMounted(fetchCategories);

function updateCategory(value) {
  emit('update:auctionCategory', value);
}
</script>
