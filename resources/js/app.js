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

import Video from './components/VideoComponent.vue';
Vue.component('video-content', Video);

import Audio from './components/AudioComponent.vue';
Vue.component('audio-content', Audio);

import Ebook from './components/EBookComponent.vue';
Vue.component('ebook-content', Ebook);

const app = new Vue({
    el: '#app'
});

//Paypal Express Checkout  

/* paypal.Button.render({
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
                    total: document.querySelector('#price').value,
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
}, '#paypal-button'); */

    // 2. This code loads the IFrame Player API code asynchronously.
      var tag = document.createElement('script');

      tag.src = "https://www.youtube.com/iframe_api";
      var firstScriptTag = document.getElementsByTagName('script')[0];
      firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
      onYouTubeIframeAPIReady();

      // 3. This function creates an <iframe> (and YouTube player)
      //    after the API code downloads.
      var player;
      function onYouTubeIframeAPIReady() {
        player = new YT.Player('player', {
          height: document.querySelector('#collapse0').offsetWidth*0.48,
          width: document.querySelector('#collapse0').offsetWidth - document.querySelector('#collapse0').offsetWidth*0.23,
          videoId: '',
          autoplay: 0,
          modestbranding: 1,
          showinfo: 1,
          events: {

          }
        });
      }

var vsebina = document.querySelectorAll('.course-module-item');
vsebina.forEach(element => {
    var parent = document.querySelector('.course-module-item').parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement;
    element.addEventListener('click', function () {
        var data = {"contenttype": this.dataset.contentType, "contentid": this.dataset.contentId};
        var ajax = new XMLHttpRequest();
        ajax.open('POST', '/api/prikazi-vsebino');
        ajax.setRequestHeader('Content-Type', 'application/json');
        ajax.onreadystatechange = function () {
            if (this.status == 200) {
                showContent(data.contenttype, this.responseText, parent);
            }
        }
        ajax.send(JSON.stringify(data));
        console.log("Type: " + this.dataset.contentType + " Id: " + this.dataset.contentId);
        //this.style.color = "rgb(244, 18, 86)";
    });
});
function showContent(type, content, parent)
{
    if (type == 'video') {
        parent.querySelectorAll('.show-module-content')[1].style.display = "none";
        parent.querySelectorAll('.show-module-content')[2].style.display = "none";
        player.loadVideoById(content);
        console.log('Parsed video by YouTube!');
        parent.querySelector('.course-module-item[data-content-type="eknjiga"]').style.color = "";
        parent.querySelector('.course-module-item[data-content-type="meditacija"]').style.color = "";
        parent.querySelector('.course-module-item[data-content-type="video"]').style.color = "rgb(244, 18, 86)";
        parent.querySelectorAll('.show-module-content')[0].style.display = "block";
    }
    else if(type == 'meditacija') {
        player.stopVideo();
        parent.querySelectorAll('.show-module-content')[0].style.display = "none";
        parent.querySelectorAll('.show-module-content')[2].style.display = "none";
        var iframeElement   = parent.querySelector('iframe#meditacija');
        var iframeElementID = iframeElement.id;
        var widget1         = SC.Widget(iframeElement);
        var widget2         = SC.Widget(iframeElementID);
        widget1.load(content);
        console.log('Parsed audio by SoundCloud!');
        parent.querySelector('.course-module-item[data-content-type="video"]').style.color = "";
        parent.querySelector('.course-module-item[data-content-type="eknjiga"]').style.color = "";
        parent.querySelector('.course-module-item[data-content-type="meditacija"]').style.color = "rgb(244, 18, 86)";
        parent.querySelectorAll('.show-module-content')[1].style.display = "block";
    }
    else if(type == 'eknjiga') {
      player.stopVideo();  
      parent.querySelectorAll('.show-module-content')[0].style.display = "none";
      parent.querySelectorAll('.show-module-content')[1].style.display = "none";
      parent.querySelectorAll('.show-module-content')[2].querySelector('.btn').href = content;
      parent.querySelector('.course-module-item[data-content-type="video"]').style.color = "";
      parent.querySelector('.course-module-item[data-content-type="meditacija"]').style.color = "";
      parent.querySelector('.course-module-item[data-content-type="eknjiga"]').style.color = "rgb(244, 18, 86)";
      parent.querySelectorAll('.show-module-content')[2].style.display = "block";
    }
}