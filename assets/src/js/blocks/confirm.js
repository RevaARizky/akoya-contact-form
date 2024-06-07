(() => {
    document.addEventListener('DOMContentLoaded', function() {
        if(!document.querySelectorAll('.confirm-wrapper .confirm').length) return false
        document.querySelectorAll('.confirm-wrapper .confirm').forEach(el => {
            el.addEventListener('click', function() {
                if(el.classList.contains('active')) {
                    return false
                }
                document.querySelectorAll('.confirm-wrapper .confirm').forEach(elLoop => { 
                    if(elLoop.classList.contains('active')) {
                        elLoop.classList.remove('active')
                        elLoop.querySelector('input').checked = false
                    }
                })
                el.classList.add('active')
                el.querySelector('input').checked = true
                
            })
        })
    })
})()