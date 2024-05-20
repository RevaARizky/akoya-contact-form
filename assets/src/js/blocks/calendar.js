(() => {

    document.addEventListener('DOMContentLoaded', function() {
        window.currentDate = new Date()
        window.currentDateActive = window.currentDate
        date = new Date(); // creates a new date object with the current date and time
        let year = date.getFullYear(); // gets the current year
        let month = date.getMonth(); // gets the current month (index based, 0-11)
        window.monthInput = month
        window.yearInput = year
        
        const day = document.querySelector(".calendar-dates"); // selects the element with class "calendar-dates"
        const currdate = document.querySelector(".calendar-current-date"); // selects the element with class "calendar-current-date"
        const inputdate = document.querySelector("#calendar-select"); // selects the element with class "calendar-current-date"
        const prenexIcons = document.querySelectorAll(".calendar-navigation span"); // selects all elements with class "calendar-navigation span"

        currdate.min = new Date().toISOString().split("T")[0];
        
        const months = [
            "January",
            "February",
            "March",
            "April",
            "May",
            "June",
            "July",
            "August",
            "September",
            "October",
            "November",
            "December"
        ]; // array of month names
        
        // function to generate the calendar
        const manipulate = () => {
            // get the first day of the month
            let dayone = new Date(year, month, 1).getDay();
        
            // get the last date of the month
            let lastdate = new Date(year, month + 1, 0).getDate();
        
            // get the day of the last date of the month
            let dayend = new Date(year, month, lastdate).getDay();
        
            // get the last date of the previous month
            let monthlastdate = new Date(year, month, 0).getDate();
        
            let lit = ""; // variable to store the generated calendar HTML
        
            // loop to add the last dates of the previous month
            for (let i=dayone; i > 0; i--) {
                lit += `<li class="inactive" data-date="${i}">${monthlastdate - i + 1}</li>`;
            }
        
            // loop to add the dates of the current month
            for (let i=1; i <=lastdate; i++) {
                // check if the current date is today
                // let isToday = i === date.getDate() && month===new Date().getMonth() && year===new Date().getFullYear() ? "active": "";
                // let isInactive = i < window.currentDate.getDate() && month == window.currentDate.getMonth() ? "inactive" : "";
                // if(year > window.currentDate.getFullYear()) {
                //     isInactive = ""
                // }
                let isToday = i === window.currentDateActive.getDate() && month===window.currentDateActive.getMonth() && year===window.currentDateActive.getFullYear() ? "active": "";
                let isInactive = ""
                if(year > window.currentDate.getFullYear()) {
                    isInactive = ""
                } else if(year == window.currentDate.getFullYear()) {
                    if(month == window.currentDate.getMonth()) {
                        if(i < window.currentDate.getDate()) {
                            isInactive = "inactive"
                        }
                    } else if(month > window.currentDate.getMonth()) {
                        isInactive = ""
                    } else if(month < window.currentDate.getMonth()) {
                        isInactive = "inactive"
                    }
                }
                lit+=`<li class="${isInactive} ${isToday} date" data-date="${i}">${i}</li>`;
            }
        
            // loop to add the first dates of the next month
            for (let i=dayend; i < 6; i++) {
                lit+=`<li class="inactive date" data-date="${i}">${i - dayend + 1}</li>`
            }
        
            // update the text of the current date element with the formatted current month and year
            currdate.innerText=`${months[month]} ${year}`;
        
            // update the HTML of the dates element with the generated calendar
            day.innerHTML=lit;

            document.querySelectorAll('.date').forEach(el => {
                el.addEventListener('click', function(e) {
                    if(el.classList.contains('active') || el.classList.contains('inactive')) {
                        return
                    }
                    document.querySelectorAll('.date').forEach(elLoop => {
                        elLoop.classList.remove('active')
                    })
                    el.classList.add('active')
                    inputdate.value = `${window.yearInput}-${window.monthInput+1}-${el.dataset.date.length >= 2 ? el.dataset.date : '0' + el.dataset.date}`
                    if(window.yearInput == window.currentDate.getFullYear() && window.monthInput == window.currentDate.getMonth() && el.dataset.date == window.currentDate.getDate()) {
                        window.currentDateActive = new Date()
                    } else {
                        window.currentDateActive = new Date(`${window.yearInput}-${window.monthInput+1}-${el.dataset.date.length >= 2 ? el.dataset.date : '0' + el.dataset.date}  `)
                    }
                    window.resetValTime()
                })
            })

        }
        
        manipulate();
        
        // Attach a click event listener to each icon
        prenexIcons.forEach(icon=> {
        
            // When an icon is clicked
            icon.addEventListener("click", ()=> {
                if(icon.id==="calendar-next" && document.querySelector('#calendar-prev').classList.contains('cf7custom-hide-nav')) {
                    document.querySelector('#calendar-prev').classList.remove('cf7custom-hide-nav')
                }
                if(icon.id==="calendar-prev" && month - 1 == window.currentDate.getMonth()) {
                    document.querySelector('#calendar-prev').classList.add('cf7custom-hide-nav')
                }
                    // Check if the icon is "calendar-prev" or "calendar-next"
                    month=icon.id==="calendar-prev" ? month - 1 : month + 1;
                    window.monthInput = month
            
                    // Check if the month is out of range
                    if (month < 0 || month > 11) {
                        // Set the date to the first day of the month with the new year
                        date=new Date(year, month, new Date().getDate());
                        // Set the year to the new year
                        year=date.getFullYear();
                        window.yearInput = year
                        // Set the month to the new month
                        month=date.getMonth();
                    }
            
                    else {
                        // Set the date to the current date
                        date=new Date();
                    }
            
                    // Call the manipulate function to update the calendar display
                    manipulate();
                    window.resetValTime()
                    if(window.innerHeight > 768) {
                        document.querySelector('.time-wrapper').style.maxHeight = `calc(${document.querySelector('.calendar-container').clientHeight}px + 20px)`
                    }
                });
        });

        const ajaxCall = (data) => {
            jQuery.ajax({
                method: "POST",
                url: '/wp-admin/admin-ajax.php',
                data: data,
                success: success
            })
        }

        inputdate.addEventListener('change', function(){

        })

        document.querySelector('form.wpcf7-form').addEventListener('wpcf7submit', function(e) {
            console.log(e.detail)
        })

        document.querySelector('#calendar-select').value=`${window.currentDate.getFullYear()}-${window.currentDate.getMonth()+1}-${window.currentDate.getDate() >= 2 ? window.currentDate.getDate() : '0' + window.currentDate.getDate()}`

    })

})()