// stylowanie submenu kalendarza
$(".submenu-events").addClass("show");
$('.nav-link[href="/calendar"]').addClass("active");

const daysTag = document.querySelector(".days"),
    currentDate = document.querySelector(".current-date"),
    prevNextIcon = document.querySelectorAll(".icons span");
    eventsContainer = document.querySelector(".events");
    eventsListContainer = document.querySelector(".eventsList");


// getting new date, current year and month
let date = new Date(),
    currYear = date.getFullYear(),
    currMonth = date.getMonth();

// storing full name of all months in array
const months = ["Styczeń", "Luty", "Marzec", "Kwiecień", "Maj", "Czerwiec", "Lipiec",
    "Sierpień", "Wrzesień", "Październik", "Listopad", "Grudzień"];

const renderCalendar = () => {
    let firstDayofMonth = new Date(currYear, currMonth, 1).getDay(), // getting first day of month
        lastDateofMonth = new Date(currYear, currMonth + 1, 0).getDate(), // getting last date of month
        lastDayofMonth = new Date(currYear, currMonth, lastDateofMonth).getDay(), // getting last day of month
        lastDateofLastMonth = new Date(currYear, currMonth, 0).getDate(); // getting last date of previous month
    let liTag = "";

    for (let i = firstDayofMonth; i > 0; i--) { // creating li of previous month last days
        liTag += `<li class="inactive">${lastDateofLastMonth - i + 1}</li>`;
    }

    for (let i = 1; i <= lastDateofMonth; i++) { // creating li of all days of current month
        // adding active class to li if the current day, month, and year matched
        let isToday = i === date.getDate() && currMonth === new Date().getMonth()
        && currYear === new Date().getFullYear() ? "active" : "";
        liTag += `<li class="${isToday}">${i}</li>`;
    }

    for (let i = lastDayofMonth; i < 6; i++) { // creating li of next month first days
        liTag += `<li class="inactive">${i - lastDayofMonth + 1}</li>`
    }
    currentDate.innerText = `${months[currMonth]} ${currYear}`; // passing current mon and yr as currentDate text
    daysTag.innerHTML = liTag;

    // autoload cuurent day event
    window.onload=function(){
        $('.active').click();
    };


    $('.days li').click(function () {
            $('.days li').removeClass('active');
            $(this).addClass('active');
            var day = $(this).text();
            const data = {search: currYear+'-'+(currMonth + 1)+'-'+day};
            fetch("/calendarSearch", {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            }).then(function (response) {
                return response.json();
            }).then(function (events) {
                if(events.length > 0){
                    loadEvents(events);
                    $('.event-date').html(day+' '+(months[currMonth])+' '+currYear);
                }else{
                    eventsContainer.innerHTML = "<h4>Brak wydarzeń w tym dniu</h4>";
                    $('.event-date').html(day+' '+(months[currMonth])+' '+currYear);
                    $('thead').css("display","none");
                }

            });
    });
    function loadEvents(events) {
        events.forEach(event => {
            console.log(event);
            eventsContainer.innerHTML = "";
            $('.table-header').css("display","table-header-group");
            $('.h4').css("display","inline-block");
            createEvent(event);
        });
    }

    function createEvent(event) {
        const template = document.querySelector("#event-template");
        const clone = template.content.cloneNode(true);
        const eventTitle = clone.querySelector(".event-title");
        eventTitle.innerHTML = event.title;
        const eventDESC = clone.querySelector(".event-desc");
        eventDESC.innerHTML = event.description;
        const eventStatus = clone.querySelector(".event-status");
        eventStatus.innerHTML = event.status;
        const eventS = clone.querySelector(".event-start");
        eventS.innerHTML = event.eventstart;
        const eventE = clone.querySelector(".event-end");
        eventE.innerHTML = event.eventend;
        const button = clone.querySelector(".btn-place");
        button.innerHTML = `<a href="eventViewDetails?event_id=${event.id}"><button type="button" class="btn-edit btn btn-primary btn-sm">Zobacz więcej</button></a>`;

        eventsContainer.appendChild(clone);
    }
}
renderCalendar();

prevNextIcon.forEach(icon => { // getting prev and next icons
    icon.addEventListener("click", () => { // adding click event on both icons
        // if clicked icon is previous icon then decrement current month by 1 else increment it by 1
        currMonth = icon.id === "prev" ? currMonth - 1 : currMonth + 1;

        if(currMonth < 0 || currMonth > 11) { // if current month is less than 0 or greater than 11
            // creating a new date of current year & month and pass it as date value
            date = new Date(currYear, currMonth, new Date().getDate());
            currYear = date.getFullYear(); // updating current year with new date year
            currMonth = date.getMonth(); // updating current month with new date month
        } else {
            date = new Date(); // pass the current date as date value
        }
        renderCalendar(); // calling renderCalendar function
    });
});








