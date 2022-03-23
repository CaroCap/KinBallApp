// Importer le CSS
import './styles/calendrier.css';

// importer les objets de fullcalendar dont on a besoin
import { Calendar } from "@fullcalendar/core";
import interactionPlugin from "@fullcalendar/interaction";
import dayGridPlugin from "@fullcalendar/daygrid";


// installez AXIOS (npm install axios) et importez-le (concrètement l'objet AXIOS)
import axios from "axios";

document.addEventListener("DOMContentLoaded", function () {
    // 1. on récupère le dataset avec le json
    let evenementsJSONJS = document.getElementById('calendrier').dataset.calendrier;
    // 2. On transforme le JSON en array d'objets JS
    let evenementsJSONJSArray = JSON.parse(evenementsJSONJS);
    // 3. On trouve la Div du calendrier
    let calendarEl = document.getElementById("calendrier");
    // initilialisation du calendrier
    var calendar = new Calendar(calendarEl, {
        events: evenementsJSONJSArray,

        displayEventTime: true, // cacher l'heure
        initialView: "dayGridMonth",
        initialDate: new Date(), // aujourd'hui
        headerToolbar: {
            left: "prev,next today",
            center: "title",
            // ! AJOUTER VUE LISTE
            right: "dayGridMonth,timeGridWeek,timeGridDay",
        },
        // ! Rajouter de nouveaux événements
        
        // liste de plugins qu'on va utiliser
        plugins: [interactionPlugin, dayGridPlugin],
    
    });

    // Affichage
    calendar.render();

});