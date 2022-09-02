(function($) {
    "use strict"; // Start of use strict

    function initMap(id, center, currentZoom, maxZoom = 19) {

        var map = L.map(id).setView(center, currentZoom);
        var tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: maxZoom,
            //attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        return map;
    };

});





