import $ from 'jquery'
import '@/blocks/calendar'
import '@/blocks/date'
import '@/blocks/confirm'
import '@/blocks/package'
import '@/blocks/email'
import Cookies from 'js-cookie'


document.addEventListener('DOMContentLoaded', function() {
    console.log(Cookies.get('cf7_data'))
    document.querySelector('form.wpcf7-form').addEventListener('wpcf7submit', function(e) {
        if(Cookies.get('cf7_data')) {
            window.location.href = '/thankyou'
        }
    })
    // document.querySelector('#service-select').value = search.get('service')
})