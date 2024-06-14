/*
 * Welcome to your app's main JavaScript file!
 *
 * Including the built version of this JavaScript file (and its CSS file)
 * in your base layout (base.html.twig) is recommended.
 */
import './styles/app.css'; // Import CSS
import './bootstrap'; // Start the Stimulus application

import { registerReactControllerComponents } from '@symfony/ux-react';
import { registerVueControllerComponents } from '@symfony/ux-vue';

// Registering controller components
registerReactControllerComponents(require.context('./react/controllers', true, /\.(j|t)sx?$/));
registerVueControllerComponents(require.context('./vue', true, /\.vue$/));

// Import Vue components
import { createApp } from 'vue';
import AuctionsList from './vue/AuctionsList.vue';
import NewAuction from './vue/NewAuction.vue';



let currentApp = null;

export const loadAuctionsList = () => {
    if (currentApp) {
        currentApp.unmount();
    }
    currentApp = createApp(AuctionsList);
    currentApp.mount('#mainView');
};

export const loadNewAuction = (tokens) => {
    if (currentApp) {
        currentApp.unmount();
    }
    currentApp = createApp(NewAuction, { tokens });
    currentApp.mount('#mainView');
};
