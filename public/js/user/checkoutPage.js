let map;

function initMap() {
    const location = { lat: 49.432973, lng: 27.004561 };

    map = new google.maps.Map(document.getElementById("map"), {
        zoom: 16,
        center: location,
    });

    const marker = new google.maps.Marker({
        position: location,
        map: map,
        title: "м.Хмельницький, вул. Зарічанська, 10",
    });

    const button = document.createElement("button");
    button.textContent = "Прокласти маршрут";
    button.classList.add("custom-map-control-button");
    map.controls[google.maps.ControlPosition.TOP_CENTER].push(button);

    button.addEventListener("click", () => {
        window.open(`https://www.google.com/maps/dir/?api=1&destination=${location.lat},${location.lng}`, "_blank");
    });

}
