<template>
  <div id="auctions-list-wrapper" class="background-white">
    <h3>Aukcje:</h3>

    <div class="grid grid-cols-4 border-bottom" v-for="auction in auctions" :key="auction['@id']">
      <div class="list-photo p-3">
        <img width="200" src="../images/image_not_available.png" title="Główne zdjęcie aukcji"/>
      </div>
      <div class="p-3 col-span-2 border-right">
        <h4>{{ auction.title }}</h4>
        <p>Kategoria: {{ auction.auctionCategory }}</p>
        <p>Stan: {{ formatProductState(auction.productState) }}</p>
        <p>ISBN: {{ auction.isbn }}</p>
      </div>
      <div class="p-3">
        <div v-html="formatProductPrice(auction.auctionBuyNowPrice)"></div>
        <div class="mt30 buy_and_pay block" rel="989">
          <div class="btn_btn btn block" @click="ffdAlert" title="Dodaj do koszyka, i kontynułuj z zakupami">
            DODAJ DO KOSZYKA
          </div>
        </div>
      </div>
    </div>


    <div v-if="totalPages > 1" class="flex justify-between">
      <button @click="changePage(currentPage - 1)" :disabled="currentPage <= 1">Poprzednia</button>
      <button @click="changePage(currentPage + 1)" :disabled="currentPage >= totalPages">Następna</button>
    </div>
  </div>

</template>

<script>
import {ref, onMounted} from 'vue';
import axios from 'axios';
//import imageNotFound from "../images/image_not_available.png";

export default {
  setup() {
    const auctions = ref([]);
    const currentPage = ref(1);
    const totalPages = ref(0);

    const fetchAuctions = (page = 1) => {
      console.log("Fetching auctions from API at page:", page);
      axios.get(`/api/auctions?page=${page}`, {
        headers: {
          'accept': 'application/ld+json'
        }
      }).then(response => {
        console.log("Data received:", response.data);
        auctions.value = response.data['hydra:member'];
        totalPages.value = Math.ceil(response.data['hydra:totalItems'] / auctions.value.length);
        currentPage.value = page;
      }).catch(error => {
        console.error('Error fetching auctions:', error);
      });
    };

    const changePage = (page) => {
      if (page > 0 && page <= totalPages.value) {
        fetchAuctions(page);
      }
    };

    const formatProductState = (value) => {
      switch (value) {
        case 'new':
          return 'Nowe';
        case 'used':
          return 'Używane';
        default:
          return 'Nieznany stan';
      }
    };

    const formatProductPrice = (value) => {
      const mainPart = Math.floor(value / 100); // Get the main part of the price by dividing by 100 and flooring it.
      const decimalPart = value % 100; // Get the remainder which represents the cents.

      return `<span class="pricebig">${mainPart},</span><span class="pricesmall">${decimalPart.toString().padStart(2, '0')} zł</span>`;
    };

    const ffdAlert = () => {
      alert('Funkcjonalność zostanie opracowana na 3roku :)');
    };

    onMounted(() => {
      fetchAuctions(currentPage.value);
    });

    return {auctions, currentPage, totalPages, changePage, formatProductState, formatProductPrice, ffdAlert};
  }
};
</script>
