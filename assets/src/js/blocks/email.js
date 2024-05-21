(($) => {
    document.addEventListener("DOMContentLoaded", () => {
        
        const main = document.querySelector('.wpcf7-email.will-check')

        if(!main) return false

        const ajaxCall = (str) => {
            $.ajax({
                method: "POST",
                url: '/wp-admin/admin-ajax.php',
                data: {
                    action: 'checkUserEmail',
                    email: str
                },
                success: data => {
                    console.log(data)
                }
            })
        }

        main.addEventListener('change', e => {
            
            
            
            e.target.value
        })

    })
})(jQuery)