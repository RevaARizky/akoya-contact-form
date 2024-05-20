(() => {
    document.addEventListener("DOMContentLoaded", function() {
        
        window.currentTime = new Date()
        const els = {
            time: document.querySelector('#time-select'),
            timewrapper: document.querySelector('.time-wrapper')
        }

        window.resetValTime = () => {
            els.time.value = ''
        }

        const renderHourComponent = (time, extraClass) => {
            return `<div class="col-span-2 md:col-span-1 md:px-16 px-8 text-center py-3 px-9 mb-6 time-pick cursor-pointer ${extraClass}" style="border: 1px solid #E1E1E1; border-radius: 8px;" data-time="${time}">${time}</div>`
        }

        const timeHandler = (e) => {
            jQuery('.time-wrapper').empty()

            if(window.currentDateActive.getHours() >= 9 && window.currentTime.getDate() == window.currentDateActive.getDate() && window.currentTime.getMonth() == window.currentDateActive.getMonth() && window.currentTime.getFullYear() == window.currentDateActive.getFullYear()) {
                loopStarti = window.currentDateActive.getHours() + 1
            } else {
                loopStarti = 9
            }
            for(let loopStart = loopStarti; loopStart <= 20; loopStart++) {
                if(window.currentTime.getDate() == window.currentDateActive.getDate() && window.currentTime.getMonth() == window.currentDateActive.getMonth() && window.currentTime.getFullYear() == window.currentDateActive.getFullYear()) {
                    if(loopStart == loopStarti) {
                        jQuery(els.timewrapper).append(renderHourComponent(`${loopStart}:00`, 'active'))
                    } else {
                        jQuery(els.timewrapper).append(renderHourComponent(`${loopStart}:00`))
                    }
                    jQuery(els.timewrapper).append(renderHourComponent(`${loopStart}:30`))
                } else {
                    if(loopStart == 20) {
                        jQuery(els.timewrapper).append(renderHourComponent(`${loopStart}:00`))
                    } else {
                        jQuery(els.timewrapper).append(renderHourComponent(`${loopStart}:00`))
                        jQuery(els.timewrapper).append(renderHourComponent(`${loopStart}:30`))
                    }
                }
            }
        }
        timeHandler()
        document.querySelector('#calendar-select').addEventListener('change', timeHandler)
        document.addEventListener("click", function(e){
          
            if(e.target.closest('.date')){
              timeHandler()
            }
            if(e.target.closest('.time-pick')) {
                els.time.value = e.target.closest('.time-pick').dataset.time
                document.querySelectorAll('.time-pick').forEach(el => {
                    if(el === e.target.closest('.time-pick')) {
                        el.classList.add('active')
                        return
                    }
                    el.classList.remove('active')
                })
            }
          });
          if(window.innerWidth > 768) {
              document.querySelector('.time-wrapper').style.maxHeight = `calc(${document.querySelector('.calendar-container').clientHeight}px + 20px)`
          }
        
    })
})()