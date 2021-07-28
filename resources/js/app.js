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
Vue.component('video-content', Video);

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

$(document).ready(() => {
/** SPA editing courses, their modules and users */

// Get form from server
$('.add-course').on('click', function () {
    var action = $(this).data('action');
    $('#exampleModal').modal('show');
    $('.modal-body').html('<div class="d-flex justify-content-center">'+
    '  <div class="spinner-border" style="color:#5dce2d;" role="status">'+
    '    <span class="sr-only">Loading...</span>'+
    '  </div>'+
    '</div>');
    $('.modal-title').html('Dodajanje novega spletnega tečaja');
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: '/api/dashboard/getform/'+action
        })
        .done(function (msg) {
            $('.modal-body').html(msg);
    });
});

// Get form for updating existing course
$('.course-link').on('click', function () {
    var courseID = $(this).data('courseid');
    $('#exampleModal').modal('show');
    $('.modal-body').html('<div class="d-flex justify-content-center">'+
    '  <div class="spinner-border" style="color:#5dce2d;" role="status">'+
    '    <span class="sr-only">Loading...</span>'+
    '  </div>'+
    '</div>');
    $('.modal-title').html('Urejanje spletnega tečaja');
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: '/api/dashboard/courses/'+courseID
        })
        .done(function (msg) {
            $('.modal-body').html(msg);
    });
});

// Get form for updating existing user
$('.user-link').on('click', function () {
    var userID = $(this).data('userid');
    $('#exampleModal').modal('show');
    $('.modal-body').html('<div class="d-flex justify-content-center">'+
    '  <div class="spinner-border" style="color:#5dce2d;" role="status">'+
    '    <span class="sr-only">Loading...</span>'+
    '  </div>'+
    '</div>');
    $('.modal-title').html('Urejanje uporabnika');
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: '/api/dashboard/users/'+userID
        })
        .done(function (msg) {
            $('.modal-body').html(msg);
    });
});

// Get form for adding new user
$('.add-newuser').on('click', function () {
    $('#exampleModal').modal('show');
    $('.modal-body').html('<div class="d-flex justify-content-center">'+
    '  <div class="spinner-border" style="color:#5dce2d;" role="status">'+
    '    <span class="sr-only">Loading...</span>'+
    '  </div>'+
    '</div>');
    $('.modal-title').html('Dodajanje novega uporabnika');
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: '/api/dashboard/users'
        })
        .done(function (msg) {
            $('.modal-body').html(msg);
    });
});
});

// Opening content by URL querystring

$(document).ready(() => {
if (window.location.search !== undefined) {
    var query = new URLSearchParams(window.location.search);
    if (query.has('video')) {
        var data = {"contenttype": "video", "contentid": query.get('video')};
        var ajax = new XMLHttpRequest();
        ajax.open('POST', '/api/prikazi-vsebino');
        ajax.setRequestHeader('Content-Type', 'application/json');
        ajax.onreadystatechange = function () {
            if (this.status == 200) {
                showContent('video', this.responseText, document.querySelector('.course-module-item').parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement);
                //console.log('Video with id: ' + this.responseText);
            }
        }
        ajax.send(JSON.stringify(data));
        //this.style.color = "rgb(244, 18, 86)";
    }
    else if(query.has('meditacija')) {
        console.log('meditacija');
    }
}
});