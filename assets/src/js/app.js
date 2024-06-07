import '@/blocks/calendar'
import '@/blocks/date'
import '@/blocks/confirm'
import '@/blocks/package'
import '@/blocks/email'
import '@/blocks/referral'
import Cookies from 'js-cookie'


document.addEventListener('DOMContentLoaded', function() {
    console.log(Cookies.get('cf7_data'))
    if(!document.querySelector('form.wpcf7-form')) return false
    document.querySelector('form.wpcf7-form').addEventListener('wpcf7submit', function(e) {
        // if(Cookies.get('cf7_data')) {
        //     window.location.href = '/thankyou'
        // }
    })
    // document.querySelector('#service-select').value = search.get('service')

    
})


document.addEventListener('DOMContentLoaded', function() {
    document.addEventListener( 'wpcf7submit', function( event ) {
        jQuery('.invalid-time').addClass('d-none')
        if(event.detail.apiResponse.invalid_fields.length > 0) {
            event.detail.apiResponse.invalid_fields.forEach(input => {
                if(input.field == 'treathour') {
                    jQuery('.invalid-time').removeClass('d-none')
                }
            })
        }
     })
    document.addEventListener( 'wpcf7mailsent', function( event ) {
        console.log(event)
        // window.location.href = '/thank-you/'
        let that = jQuery(this)
        var form = document.createElement('form');
        form.setAttribute('method', 'post');
        if(window.env == 'test') {
            form.setAttribute('action', '/?page_id=7112');
        } else {
            form.setAttribute('action', '/thank-you');
        }
        form.style.display = 'hidden';
        event.detail.inputs.forEach(input => {
            let inputVal = document.createElement("input");
            inputVal.setAttribute("type", "hidden");
            inputVal.setAttribute("name", input.name);
            inputVal.setAttribute("value", input.value);
            form.appendChild(inputVal);
        })
        document.body.appendChild(form);
        form.submit();
    }, false );

    if(!document.querySelector('#calendar-select')) return false
    setTimeout(() => {
        let date = new Date();
        document.querySelector('#calendar-select').value = `${date.getFullYear()}-${`${date.getMonth()+1}`.length >= 2 ? `${date.getMonth()+1}` : `0${date.getMonth()+1}`}-${`${date.getDate()}`.length >= 2 ? date.getDate() : '0' + date.getDate()}`
    }, 1000);
})