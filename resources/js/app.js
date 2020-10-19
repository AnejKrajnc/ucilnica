/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import Vue from 'vue';
import LoadScript from 'vue-plugin-load-script';

import paypal from 'paypal-checkout';

require('./bootstrap');

Vue.use(LoadScript);
Vue.use(paypal);

window.Vue = require('vue');
 
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
import PaypalCheckout from './components/PaypalCheckout.vue';
Vue.component('paypal-checkout', PaypalCheckout);

const app = new Vue({
    el: '#app'
});

//Paypal Express Checkout  

paypal.Button.render({
    // Configure environment
    env: 'sandbox',
    client: {
        sandbox: 'true',
        production: 'AYC4xTxGRw3ZJr2Do41D9FI-i2nEkoew2vwggla9Y9FhCKYc7X7aesqEtLoFMoUkcjUpLptYeBqA6iRC'
    },
    // Customize button (optional)
    locale: 'en_SI',
    style: {
        size: 'large',
        color: 'gold',
        shape: 'pill',
    },
    // Set up a payment
    payment: function (data, actions) {
        return actions.payment.create({
            transactions: [{
                amount: {
                    total: '17.90',
                    currency: 'EUR'
                }
            }]
      });
    },
    // Execute the payment
    onAuthorize: function (data, actions) {
        return actions.payment.execute()
        .then(function () {
            // Show a confirmation message to the buyer
            //window.alert('Thank you for your purchase!');
            
            // Redirect to the payment process page
            window.location = "/nakup/"+process_token+"?paymentID="+data.paymentID+"&token="+data.paymentToken+"&payerID="+data.payerID+"&pid=<?php echo $productData['id']; ?>";
        });
    }
}, '#paypal-button');

var vsebina = document.querySelectorAll('.course-module-item');
vsebina.forEach(element => {
    element.addEventListener('click', function () {
        console.log("Type: " + this.dataset.contentType + " Id: " + this.dataset.contentId);
    });
});