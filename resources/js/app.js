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
        var active = this;
        var data = {"contenttype": this.dataset.contentType, "contentid": this.dataset.contentId};
        var ajax = new XMLHttpRequest();
        ajax.open('POST', '/api/prikazi-vsebino');
        ajax.setRequestHeader('Content-Type', 'application/json');
        $('.course-module-item').css('color', '');
        $(parent).find('.content-shower').html('<div class="spinner-border" style="color: #5dce2d;" role="status">'+
        '  <span class="sr-only">Loading...</span>'+
        '</div>');
        ajax.onreadystatechange = function () {
            if (this.status == 200) {
                showContent(data.contenttype, this.responseText, parent);
                $(active).css('color', '#5dce2d');
                if (parent.clientWidth < 481) {
                    if (data.contenttype == 'meditacija') {
                        parent.querySelector('iframe').width = parent.clientWidth - 15;
                        parent.querySelector('iframe').height = parent.clientWidth - 15;
                    }
                    else if (data.contenttype == 'video') {
                        parent.querySelector('iframe').width = parent.clientWidth - 15;
                        parent.querySelector('iframe').height = "auto";
                    }
                }
            }
        }
        ajax.send(JSON.stringify(data));
        console.log("Type: " + this.dataset.contentType + " Id: " + this.dataset.contentId);
    });
});

function showContent(type, content, parent)
{
    $(parent).find('.content-shower').html(content);
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
        url: '/api/dashboard/getform/' + action
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

// Get form for updating modulecontent
$('.modulecontent-link').on('click', function () {
    var modulecontentID = $(this).data('modulecontentid');
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
        url: '/api/dashboard/modulecontent/'+modulecontentID
        })
        .done(function (msg) {
            $('.modal-body').html(msg);
    });
});

});

// Opening content by URL querystring
/* 
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
*/

$(document).ready(function(){
    $("#searchbox").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $("#uporabniki tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });
    var slika = document.getElementById('InputSlikica');
                slika.onchange = evt => {
                    const [file] = slika.files;
                    if (file) {
                        document.querySelector('#predogledSlikice').src = URL.createObjectURL(file);
                    }
                    }
  });