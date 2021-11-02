/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';
import 'fullcalendar/main.min.css'
import '@fullcalendar/common/main.min.css'
// start the Stimulus application
import './bootstrap';
import TomSelect from "tom-select";
import {Calendar} from "@fullcalendar/core";
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import listPlugin from '@fullcalendar/list';
import interactionPlugin from '@fullcalendar/interaction';



const bootstrap = require('bootstrap')


console.log("app.js")

/**
 *
 * @param url
 * @returns {Promise<null|any>}
 */
async function jsonfetch(url) {
    const response =await fetch(url,{
        headers:{
            Accept: 'application/json'
        }
    })
    if (response.status === 204)
    {
        return null
    }
    if (response.ok){
        return  await response.json()
    }
}

/**
 *
 * @param {HTMLSelectElement} select
 */
function bindSelect(select){
    new TomSelect(select, {
        hideSelected: true,
        closeAfterSelect: true,
        valueField: select.dataset.value,
        labelField:select.dataset.label,
        searchField: select.dataset.label,
        plugins:{
            remove_button:{
                title: 'Remove this item'
            }
        },
        load: async (query ,callback)=>{
            const url = `${select.dataset.remote}?q=${encodeURIComponent(query)}`
            console.log(url )
            callback(await jsonfetch(url))

        }
    })
}

Array.from(document.querySelectorAll('select[multiple]')).map(bindSelect)

// ClassicEditor
//     .create( document.querySelector( '#editor' ) )
//     .catch( error => {
//         console.error( error );
//     } );


window.onload = () => {
    let calendarElt = document.querySelector("#calendar")
    let calendar;
    const data = document.querySelector("#calendar_data").innerHTML
    console.log( data)
    calendar = new Calendar(calendarElt, {
        plugins: [ dayGridPlugin, timeGridPlugin, listPlugin, interactionPlugin ],
        themeSystem: 'bootstrap',
        initialView: 'timeGridWeek',
        locale: 'fr',
        timeZone: 'Europe/Paris',
        headerToolbar:{
            start: 'prev,next today',
            center: 'title',
            end:'dayGridMonth,timeGridWeek',
        },
        editable: true,
        events: JSON.parse(data),
        nowIndicator: true,
        navLinks: true,
        dateClick: function(info) {
            alert('clicked ' + info.dateStr);
        },
        // eventDidMount: function(info) {
        //     var tooltip = new Tooltip(info.el, {
        //         title: info.event.extendedProps.description,
        //         placement: 'top',
        //         trigger: 'hover',
        //         container: 'body'
        //     });
        // },

    });

    calendar.on('eventChange', async (e) =>{
        console.log(e)
        const data = {
            'id': e.event.id,
            'name': e.event.title,
            'startAt': e.event.start,
            'endAT': e.event.end,
            'allDay': e.event.allDay,
            'textcolor': e.event.textColor,
            'bgcolor': e.event.backgroundColor,
            'bordercolor': e.event.borderColor,
            'description': e.event.extendedProps.description
        }
         const response =await fetch(`/api/maj_event/${e.event.id}`,{
             method:'POST',
             headers:{
                 Accept: 'application/json'
             },
             body: JSON.stringify(data)
         })
        console.log(response)
        if (response.status === 204)
        {
            return null
        }
        if (response.ok){
            return  await response.json()
        } else {
            alert("data no persisted /!")
            e.revert();
        }
    })
    calendar.render()
}

document.querySelectorAll('.delete_doc').forEach(a => {
    console.log(a)
    a.addEventListener('click' , e => {
        e.preventDefault()
        fetch(a.getAttribute('href'),{
            method: 'DELETE',
            headers: {
                'X-Requested-With':'XMLHttpRequest',
                'Content-Type': 'application/json'

            },

        }).then(response => response.json())
            .then(data =>{
                if (data.success){
                    a.parentNode.parentNode.parentNode.removeChild(a.parentNode.parentNode)
                }else{
                    alert(data.error)
                }
            })
            .catch(e=>alert(e))

    })
})