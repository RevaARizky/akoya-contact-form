import utils from "@/utils";

document.addEventListener('DOMContentLoaded', ($) => {
    const main = document.querySelector('input[data-referral]')
    if(!main) return false;

    const resetState = () => {
        main.parentElement.classList.remove('success')
        main.parentElement.querySelector('.response-handler').style.display = 'none'
    }

    const successHandler = () => {
        main.parentElement.classList.add('success')
        return true
    }

    const cbHandler = ( res ) => {
        res = JSON.parse(res)
        if(parseInt(res.status) != 200) {
            return utils.errorHandler({message: 'Something went wrong. Please try again later', level: 1, el: main.parentElement.querySelector('.response-handler')})
        }

        if(!res.found) {
            return utils.errorHandler({message: 'Referral code not valid', level: 2, el: main.parentElement.querySelector('.response-handler')})
        }

        return successHandler()
    }

    const ajaxCall = (data) => {
        jQuery.ajax({
            method: "POST",
            url: '/wp-admin/admin-ajax.php',
            data: {
                action: '_akoya_ref_check_ref_code',
                code: data
            },
            success: cbHandler
        })
    }



    main.addEventListener('change', () => {
        resetState()
        if(main.value) {
            ajaxCall(main.value)
        }
    })
})