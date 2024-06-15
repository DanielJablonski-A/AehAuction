<template>
  <div class="auction-form">
    <h3>Dodaj nową aukcję</h3>
    <form @submit.prevent="submitAuction">
      <div class="form-group">
        <label for="title">Tytuł:</label>
        <input id="title" v-model="formData.title" required class="w-full">
      </div>
      <NewAuctionAuctionsCategories v-model:auctionCategory="formData.auctionCategory"></NewAuctionAuctionsCategories>
      <div class="form-group">
        <label for="productState">Stan produktu:</label>
        <select id="productState" v-model="formData.productState" required>
          <option value="new">Nowe</option>
          <option value="used">Używane</option>
        </select>
      </div>
      <div class="form-group">
        <label for="isbn">ISBN(EAN):</label>
        <input id="isbn" v-model="formData.isbn" required>
      </div>
      <div class="form-group">
        <label for="description">Opis:</label>
        <textarea id="description" v-model="formData.description" required></textarea>
      </div>
      <div class="form-group">
        <label for="quantity">Ilość:</label>
        <input type="number" id="quantity" v-model.number="formData.quantity" min="1" required>
      </div>
      <div class="form-group">
        <label for="quantityType">Typ ilości:</label>
        <select id="quantityType" v-model="formData.quantityType" required>
          <option value="szt.">sztuki</option>
          <option value="kg.">kilogramy</option>
          <option value="l.">litry</option>
        </select>
      </div>
      <div class="form-group">
        <label for="auctionDuration">Czas trwania aukcji (dni):</label>
        <input type="number" id="auctionDuration" v-model.number="formData.auctionDuration" min="1" required>
      </div>
      <div class="form-group">
        <label for="auctionBuyNowPrice">Cena Kup Teraz:</label>
        <input type="number" id="auctionBuyNowPrice" v-model.number="formData.auctionBuyNowPrice" min="1" required>
      </div>
      <NewAuctionCourier v-model:courier="formData.courier"></NewAuctionCourier>

      <!-- Display errors -->
      <div v-if="errors.length" class="errors">
        <p v-for="error in errors" :key="error">{{ error }}</p>
      </div>

      <button class="ph15 btn btn_btn" type="submit">Dodaj aukcję</button>
    </form>
  </div>
</template>

<script setup>
import {computed, reactive, ref} from 'vue';
import axios from 'axios';
import NewAuctionAuctionsCategories from './NewAuctionAuctionsCategories.vue'
import NewAuctionCourier from "./NewAuctionCourier.vue";
import {loadAuctionsList} from "../app";

const props = defineProps({
  tokens: {
    type: [String, Array, Object],
    default: () => []
  }
});

if (props.tokens === null) {
  alert("Prosimy się najpierw zalogować");
}

const firstToken = computed(() => props.tokens ? props.tokens[0] : null)

const formData = reactive({
  auctionCategory: '',
  title: '',
  productState: 'new',
  isbn: '',
  description: '',
  isCompany: true,
  quantity: 1,
  quantityType: '',
  auctionDuration: 1,
  auctionBuyNowPrice: 0,
  auctionBidStartPrice: 0,
  courier: '',
  courierPrePaymentPrice: 0,
  courierAfterDeliveryPaymentPrice: 0,
  dateTimeAdd: new Date().toISOString(),
  dateTimeModify: new Date().toISOString(),
  dateTimeDeleted: new Date().toISOString(),
});

const errors = ref([]);

const submitAuction = () => {
  console.log("Token used for submission:", firstToken.value);  // Debug log for checking the token

  if (firstToken.value === null) {
    alert("Prosimy się najpierw zalogować");
    return;
  }

  const config = {
    headers: {
      'Authorization': 'Bearer ' + firstToken,  // Ensure the token is correctly concatenated
      'Content-Type': 'application/json'
    }
  };

  axios.post('/api/auctions', formData, config)
      .then(response => {
        alert('Sukces! Aukcja została dodana.');
        console.log('Response:', response);
        loadAuctionsList();
      })
      .catch(error => {
        console.error('Error submitting auction:', error);
        if (error.response) {
          if (error.response.data.violations) {
            error.response.data.violations.forEach(violation => {
              errors.value.push(`${violation.propertyPath}: ${violation.message}`);
            });
          } else {
            // Domyślny komunikat o błędzie z serwera
            errors.value.push(error.response.data['hydra:description'] || 'Błąd serwera.');
          }
        } else if (error.request) {
          // Brak odpowiedzi od serwera
          errors.value.push('Brak odpowiedzi od serwera. Prosimy spróbować później.');
        } else {
          // Błąd w trakcie ustawiania żądania
          errors.value.push('Błąd w trakcie wysyłania żądania. Prosimy spróbować później.');
        }

        let errorMessage = 'Wystąpił błąd podczas dodawania aukcji: ' + error.message;
        errors.value.push(errorMessage);
      });
};

</script>

