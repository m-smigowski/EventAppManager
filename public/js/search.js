const search = document.querySelector("#search-input");
const eventContainer = document.querySelector(".events");
const titleH2 = document.querySelector("h1.h3");


search.addEventListener("keyup", function (event) {
    if (event.key === "Enter") {
        event.preventDefault();

        const data = {search: this.value};

        fetch("/search", {
            method: "POST",
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        }).then(function (response) {
            return response.json();
        }).then(function (events) {
            eventContainer.innerHTML = "";
            loadEvents(events)
        });
    }
});

function loadEvents(events) {
    events.forEach(event => {
        console.log(event);
        createEvent(event);
    });
}

function createEvent(event) {

    const template = document.querySelector("#event-template");

    const clone = template.content.cloneNode(true);
    const eventID = clone.querySelector(".event-id");
    eventID.innerHTML = event.id;

    const eventTitle = clone.querySelector(".event-title");
    eventTitle.innerHTML = event.title;

    const eventDESC = clone.querySelector(".event-desc");
    eventDESC.innerHTML = event.description;

    const eventStatus = clone.querySelector(".event-status");
    eventStatus.innerHTML = event.status;

    const eventType = clone.querySelector(".event-type");
    eventType.innerHTML = event.type;

    const eventS = clone.querySelector(".event-start");
    eventS.innerHTML = event.eventstart;

    const eventE = clone.querySelector(".event-end");
    eventE.innerHTML = event.eventend;

    const button = clone.querySelector(".btn-edit");
    button.innerHTML = `<a href="eventViewDetails?event_id=${event.id}">Zobacz więcej</a>`;

    titleH2.innerHTML = "Wyszukane wydarzenia";

    eventContainer.appendChild(clone);
}
