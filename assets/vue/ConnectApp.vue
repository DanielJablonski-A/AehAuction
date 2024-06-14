<template>
  <PageTop></PageTop>
  <div class="background flex flex-col">
    <div class="border-bottom flex-auto flex flex-col sm:flex-row justify-center px-8">
      <div class="sm:ml-3 sm:w-1/2 md:w-2/3">
        <div id="mainView" class="py-3">


          <div class="flex-auto flex flex-col sm:flex-row justify-center px-8 pt-4">
            <LoginForm v-on:user-authenticated="onUserAuthenticated"></LoginForm>
            <div class="background-white sm:ml-4 px-8 pt-8 pb-8 mb-4 sm:w-1/2 md:w-1/2 text-center">
              <div v-if="user">
                Zalogowany jako: <strong>{{ user.username }}</strong>
                | <a href="/logout" class="underline">Wyloguj się</a>
                <br>
                <h3 class="text-left font-semibold mt-2">Tokens</h3>
                <div v-if="null === tokens">Odświerz by zobaczyć tokeny...</div>
                <dl v-else class="text-left max-w-md text-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                  <div class="flex flex-col py-3" v-for="token in tokens" :key="token">
                    <dd class="text-xs whitespace-normal break-words">{{ token }}</dd>
                  </div>
                </dl>
              </div>
              <div v-else>Nie zalogowany. Prosimy się zalogować.</div>

              <hr class="my-10 mx-auto" style="border-top: 1px solid #ccc; width: 70%;"/>

              <p><a :href="entrypoint" class="underline">Dokumentacja API</a></p>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>


</template>

<script setup>
import {ref} from 'vue';
import LoginForm from './LoginForm.vue';
import PageTop from "./PageTop.vue";

const props = defineProps(['entrypoint', 'user', 'tokens'])
const user = ref(props.user);

const onUserAuthenticated = async (userUri) => {
  const response = await fetch(userUri);
  user.value = await response.json();
}
</script>
