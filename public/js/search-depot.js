const search = document.querySelector("#search-depot-input");
const depotContainer = document.querySelector(".items");
const titleH2 = document.querySelector("h1.h2");


search.addEventListener("keyup", function (item) {
    if (item.key === "Enter") {
        item.preventDefault();

        const data = {search: this.value};

        fetch("/searchDepot", {
            method: "POST",
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        }).then(function (response) {
            return response.json();
        }).then(function (items) {
            depotContainer.innerHTML = "";
            loadItems(items)
        });
    }
});

function loadItems(items) {
    items.forEach(item => {
        console.log(item);
        createItem(item);
    });
}
function createItem(item) {

    const template = document.querySelector("#item-template");
    const clone = template.content.cloneNode(true);
    const itemID = clone.querySelector(".item-id");
    itemID.innerHTML = item.id;

    const itemImage = clone.querySelector(".item-image");
    itemImage.innerHTML = `<img width="150px" height="150px" src="public/img/uploads/${item.image}">`;

    const itemName = clone.querySelector(".item-name");
    itemName.innerHTML = item.name;

    const itemDesc = clone.querySelector(".item-desc");
    itemDesc.innerHTML = item.description;

    const itemBarcode = clone.querySelector(".item-barcode");
    itemBarcode.innerHTML = item.barcode;

    const itemQuantity = clone.querySelector(".item-quantity");
    itemQuantity.innerHTML = item.quantity;

    const button = clone.querySelector(".btn-edit");
    button.innerHTML = `<a href="editDepotItem?item_id=${item.id}&barcode=${item.barcode}">Edytuj</a>`;

    titleH2.innerHTML = "Wyszukane przedmioty w magazynie";
    depotContainer.appendChild(clone);
}
