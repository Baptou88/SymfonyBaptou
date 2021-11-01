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
import TomSelect from "tom-select";


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