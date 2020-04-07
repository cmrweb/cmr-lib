"use strict";
function sw_register(){
if ('serviceWorker' in navigator) {
    try {
        navigator.serviceWorker.register('serviceWorker.js');
    } catch (error) {
        console.log(error);
    }
    window.addEventListener('beforeinstallprompt', (e) => {
        e.preventDefault();
        showInstallPromotion(e);
    });
}
}
/*
PWA
*/

let deferredPrompt;
var btnAdd = document.getElementById('AppInstall');
function showInstallPromotion(deferredPrompt) {
        deferredPrompt.prompt();
        deferredPrompt.userChoice.then((choiceResult) => {
            if (choiceResult.outcome === 'accepted') {
                console.log('User accepted the A2HS prompt');
            } else {
                console.log('User dismissed the A2HS prompt');
            }
            deferredPrompt = null;
        });
}

window.addEventListener('appinstalled', function () {
    app.logEvent('a2hs', 'installed');
});
if (window.matchMedia('(display-mode: standalone)').matches) {
    console.log('display-mode is standalone');
}
/**
 * detect online offline
 */
function updateOnlineStatus(msg) {
    var status = document.getElementById("footer");
    var condition = navigator.onLine ? "ONLINE" : "OFFLINE";   
    console.log(condition)
    status.setAttribute("class", condition);
  }

function loaded() {
    updateOnlineStatus("load");
    document.body.addEventListener("offline", function () {
        updateOnlineStatus("offline")
    }, false);
    document.body.addEventListener("online", function () {
        updateOnlineStatus("online")
    }, false);
}

// var showHeader = false;
// function openPopup() {
//     $('.formSign').hide()
//     $('.formLog').hide()
//     $('.formBall,.background').hide()
//     $(".newMsg ,.background").click((e) => {
//         e.preventDefault()
//         $('.formBall,.background').toggle('fast')
//     });
//     $(".menu").click((e) => {
//         e.preventDefault()
//         $('.nav').slideToggle('fast')
//         if (!showHeader) {
//             $(".header").css({
//                 'position': 'relative',
//                 'top': '-10px'
//             })
//             showHeader = true;
//         } else {
//             $(".header").css({
//                 'position': 'relative',
//                 'top': '-75px'
//             })
//             showHeader = false;
//         }

//     });

//     if ($('.popupBtn').length) {
//         var popupBtn = $('.popupBtn');
//         popupBtn[0].addEventListener('click', (e) => {
//             e.preventDefault()
//             $('.formSign').toggle('fast')
//             $('.formLog').hide()
//         });
//         popupBtn[1].addEventListener('click', (e) => {
//             e.preventDefault()
//             $('.formLog').toggle('fast')
//             $('.formSign').hide()
//         });
//     }


// }
    //add step Contact add contact modal
    let openModal = (id = null) => {
        if (id) {
            document.getElementById(id).classList.toggle("hide");
            document.getElementById("bgCover").classList.toggle("hide");
        } else {
            document.getElementById("bgCover").classList.add("hide");
            for (let i = 0; i < $('.cmrModal').length; i++) {
                $('.cmrModal')[i].classList.add("hide");
            }
        }

    }
    function openNav(){
        $(".nav").css({
            display: 'block',
            background: 'var(--dark)'
        })
    }
    
$(document).ready(function () {
    //openPopup();
    var forLoop = document.getElementsByTagName('for');
    let imgs = document.getElementsByTagName('img');
    for (let i = 0; i < imgs.length; i++) {
        if (imgs[i].getAttribute('src') == "asset/img/upload/")
            imgs[i].remove();
    }

});