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

const props = defineProps({
  tokens: {
    type: [String, Array, Object],
    default: () => []  // Providing a default can help avoid undefined errors
  }
});

const firstToken = computed(() => props.tokens.length > 0 ? props.tokens[0] : 'No token available');

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
  const config = {
    headers: {
      'Authorization': 'Bearer ' + firstToken,
      'Content-Type': 'application/json'
    }
  };

  axios.post('/api/auctions', formData, config)
      .then(response => {
        alert('Sukces! Aukcja została dodana.');
        console.log('Response:', response);
        // ok jazda!
        //
      })
      .catch(error => {
        console.error('Error submitting auction:', error);
        let errorMessage = 'Wystąpił błąd podczas dodawania aukcji.';
        // errors.value = []; // Clear previous errors
        // if (error.response && error.response.data['hydra:description']) {
        //   errors.value.push(error.response.data['hydra:description']);
        // } else {
        //   errors.value.push('Unknown error occurred, please try again.');
        // }

        // Sprawdź, czy błąd zawiera odpowiedź serwera
        if (error.response) {
          // Serwer odpowiedział kodem stanu poza zakresem 2xx
          console.log(error.response.data);
          console.log(error.response.status);
          console.log(error.response.headers);

          if (error.response.status === 400) {
            // More specific error message from the server if available
            errorMessage = error.response.data['hydra:description'] || 'Błędne dane wejściowe.';
          } else if (error.response.status === 401) {
            errorMessage = 'Nieautoryzowany dostęp. Sprawdź swoje dane logowania.';
          } else if (error.response.status === 500) {
            errorMessage = 'Błąd serwera. Prosimy spróbować później.';
          } else {
            errorMessage = `Błąd: ${error.response.status}`;
          }

          if (error.response.data.violations) {
            error.response.data.violations.forEach(violation => {
              errors.value.push(`${violation.propertyPath}: ${violation.message}`);
            });
          }

        } else if (error.request) {
          // Żądanie zostało wysłane, ale nie otrzymano odpowiedzi
          errorMessage = 'Brak odpowiedzi od serwera. Prosimy spróbować później.';
        } else {
          // Coś poszło nie tak w trakcie tworzenia żądania
          errorMessage = 'Błąd w trakcie wysyłania żądania. Prosimy spróbować później.';
        }

        //alert(errorMessage);
      });
};
</script>

