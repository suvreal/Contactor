/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

// start the Stimulus application
import './bootstrap';

// require jQuery normally
const $ = require('jquery');

// create global $ and jQuery variables
global.$ = global.jQuery = $;


// jQuery events

function modalHide(){

        //$(".modal").hide();

        var modals = document.getElementsByClassName("modal"); //divsToHide is an array
        for(var i = 0; i < modals.length; i++) {
            // modals[i].style.visibility = "hidden";
            modals[i].style.display = "none";
        }

}

// Record note show modal
$(document).ready(function() {
    $(".note-popup-btn").click(function(e) {
        $(this).children(".modal").show();
    });
});

// (x) click hide modal
$(document).on('click', '.close', function() { modalHide(); });

// click out modal hide
$(document).on('click', '.modal', function(e) {
    if(e.target.classList.contains("modal") && !e.target.classList.contains("modal-content")) {
        modalHide();
    }
});

// Popup escape hide
$(document).keyup(function(e) {
    if (e.key === "Escape") { // escape key maps to keycode `27`
        modalHide();
    }
});



