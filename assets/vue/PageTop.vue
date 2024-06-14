<template>
  <div class="background-top flex flex-col">
    <div class="border-bottom flex-auto flex flex-col sm:flex-row justify-center px-8">
      <div class="sm:ml-3 sm:w-1/2 md:w-2/3">
        <div class="py-3">
          <img class="" :src="logoPath" alt="AleAEH Logo">
        </div>
      </div>
    </div>

    <div class="border-bottom flex-auto flex flex-col sm:flex-row justify-center px-8">
      <div class="sm:ml-3 sm:w-1/2 md:w-2/3">
        <div class="py-3 menu">
          <nav>
            <ul class="main_ul mgn2_14 mp0t_0a mqu1_21 mgmw_wo mli8_k4 f428b_eRXGb f428b_CVnSU mp0t_0a mgn2_14 mqu1_21 mgmw_wo mli8_k4 mb54_5r mg9e_0 mvrt_0 mj7a_0 mh36_0 mp4t_0 m3h2_0 mryx_0 munh_0 mp7g_oh">
              <li class="mp7g_oh">
                <a class="mgn2_14 mp0t_0a mgmw_wo mqu1_21 mj9z_5r mli8_k4 mqen_m6 l1fas" href="#"
                   @click="loadAuctionsList">
                  Strona Główna
                </a>
              </li>
              <li class="mp7g_oh">
                <a class="mgn2_14 mp0t_0a mgmw_wo mqu1_21 mj9z_5r mli8_k4 mqen_m6 l1fas" href="/login_form">
                  Login
                </a>
              </li>
              <li class="mp7g_oh">
                <a class="mgn2_14 mp0t_0a mgmw_wo mqu1_21 mj9z_5r mli8_k4 mqen_m6 l1fas" href="/api">Dokumentacja
                  API</a>
              </li>
              <!--              <li class="mp7g_oh">-->
              <!--                <a class="mgn2_14 mp0t_0a mgmw_wo mqu1_21 mj9z_5r mli8_k4 mqen_m6 l1fas" href="#"-->
              <!--                   onclick="loadLoginForm(); return false;">-->
              <!--                  Wszystkie aukcje-->
              <!--                </a>-->
              <!--              </li>-->
              <li class="mp7g_oh">
                <a class="mgn2_14 mp0t_0a mgmw_wo mqu1_21 mj9z_5r mli8_k4 mqen_m6 l1fas" href="#"
                   @click="loadNewAuction(tokens)">
                  Wystaw nową aukcje
                </a>
              </li>
            </ul>
          </nav>
        </div>
      </div>
    </div>
  </div>

</template>

<script setup>
import {inject} from "vue";
import logoPath from "../images/logo.jpg";
import {loadAuctionsList, loadNewAuction} from "../app";

const tokens = inject('tokens');

</script>