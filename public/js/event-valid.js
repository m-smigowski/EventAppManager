function validateEventForm() {
    let event_start = document.forms["event-form"]["event_start"].value;
    let event_end = document.forms["event-form"]["event_end"].value;
    let myModal = new bootstrap.Modal(document.getElementById('myModal'));
    let modalBody = document.getElementsByClassName("modal-body")[0];

    if(event_end<=event_start) {
        modalBody.innerHTML = "Niepoprawna data zakończenia wydarzenia.";
        myModal.show();
        return false;
    }
}