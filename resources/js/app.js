/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import Vue from 'vue';
import LoadScript from 'vue-plugin-load-script';

require('./bootstrap');

Vue.use(LoadScript);

window.Vue = require('vue');
 
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import Video from './components/VideoComponent.vue';
Vue.component('video-content', {props: ['video']}, Video);

import Audio from './components/AudioComponent.vue';
Vue.component('audio-content', Audio);

import Ebook from './components/EBookComponent.vue';
Vue.component('ebook-content', Ebook);
const app = new Vue({
    el: '#app'
});
var video = new Array(document.querySelectorAll('.player').length);
    // 2. This code loads the IFrame Player API code asynchronously.
      var tag = document.createElement('script');

      tag.src = "https://www.youtube.com/iframe_api";
      var firstScriptTag = document.getElementsByTagName('script')[0];
      firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
      onYouTubeIframeAPIReady();

      // 3. This function creates an <iframe> (and YouTube player)
      //    after the API code downloads.
      function onYouTubeIframeAPIReady() {

    var players = document.querySelectorAll('.player');
    players = players.forEach((player, i) => {
        player.dataset.playerId = i;
        player = new YT.Player(player, {
            height: document.querySelector('#collapse0').offsetWidth*0.48,
            width: document.querySelector('#collapse0').offsetWidth - document.querySelector('#collapse0').offsetWidth*0.23,
            videoId: '',
            autoplay: 0,
            modestbranding: 0,
            showinfo: 0
        });
        video[i] = player;
    });
      }

var vsebina = document.querySelectorAll('.course-module-item');
vsebina.forEach(element => {
    var parent = element.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement;
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
        if(parent.querySelectorAll('.show-module-content')[1]) {parent.querySelectorAll('.show-module-content')[1].style.display = "none";}
        parent.querySelectorAll('.show-module-content')[2].style.display = "none";
        var index = parent.querySelector('.player').getAttribute("data-player-id");
        video[index].loadVideoById(content);
        console.log('Parsed video by YouTube!');
        if(parent.querySelector('.course-module-item[data-content-type="eknjiga"]')) {parent.querySelector('.course-module-item[data-content-type="eknjiga"]').style.color = "";}
        if(parent.querySelector('.course-module-item[data-content-type="meditacija"]')) {parent.querySelector('.course-module-item[data-content-type="meditacija"]').style.color = "";}
        if(parent.querySelector('.course-module-item[data-content-type="video"]')) {parent.querySelector('.course-module-item[data-content-type="video"]').style.color = "rgb(244, 18, 86)";
        if(parent.querySelectorAll('.show-module-content')[0]) {parent.querySelectorAll('.show-module-content')[0].style.display = "block"; }
    }
}
    else if(type == 'meditacija') {
        video.forEach((x) => {
            x.stopVideo();
        });
        if(parent.querySelectorAll('.show-module-content')[0]) {parent.querySelectorAll('.show-module-content')[0].style.display = "none"; }
        if(parent.querySelectorAll('.show-module-content')[2]) {parent.querySelectorAll('.show-module-content')[2].style.display = "none"; }
        var iframeElement   = parent.querySelector('iframe#meditacija');
        var iframeElementID = iframeElement.id;
        var widget1         = SC.Widget(iframeElement);
        var widget2         = SC.Widget(iframeElementID);
        widget1.load(content);
        console.log('Parsed audio by SoundCloud!');
        if(parent.querySelector('.course-module-item[data-content-type="video"]')) {parent.querySelector('.course-module-item[data-content-type="video"]').style.color = ""; }
        if(parent.querySelector('.course-module-item[data-content-type="eknjiga"]')) {parent.querySelector('.course-module-item[data-content-type="eknjiga"]').style.color = ""; }
        if(parent.querySelector('.course-module-item[data-content-type="meditacija"]')) {parent.querySelector('.course-module-item[data-content-type="meditacija"]').style.color = "rgb(244, 18, 86)"; }
        if(parent.querySelectorAll('.show-module-content')[1]) {parent.querySelectorAll('.show-module-content')[1].style.display = "block"; }
    }
    else if(type == 'eknjiga') {
        video.forEach((x) => {
            x.stopVideo();
        }); 
      if(parent.querySelectorAll('.show-module-content')[0]) {parent.querySelectorAll('.show-module-content')[0].style.display = "none"; }
      if(parent.querySelectorAll('.show-module-content')[1]) {parent.querySelectorAll('.show-module-content')[1].style.display = "none"; }
      if(parent.querySelectorAll('.show-module-content')[2]) {parent.querySelectorAll('.show-module-content')[2].querySelector('.btn').href = "/tecaji/" + content;}
      if(parent.querySelector('.course-module-item[data-content-type="video"]')) {parent.querySelector('.course-module-item[data-content-type="video"]').style.color = ""; }
      if(parent.querySelector('.course-module-item[data-content-type="meditacija"]')) {parent.querySelector('.course-module-item[data-content-type="meditacija"]').style.color = ""; }
      if(parent.querySelector('.course-module-item[data-content-type="eknjiga"]')) {parent.querySelector('.course-module-item[data-content-type="eknjiga"]').style.color = "rgb(244, 18, 86)"; }
      if(parent.querySelectorAll('.show-module-content')[2]) {parent.querySelectorAll('.show-module-content')[2].style.display = "block"; }
    }
}