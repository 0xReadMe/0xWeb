jQuery(document).ready(function () {
    $('.video-gallery-wrapper').tinycarousel();
    $('.office-gallery-wrapper').tinycarousel({
        bullets: true,
        buttons: false
    });
    $('.video-slide a').magnificPopup({
        disableOn: 700,
        type: 'iframe',
        mainClass: 'mfp-fade',
        removalDelay: 160,
        preloader: false,
        fixedContentPos: false
    });
});


function TxtOverlay(pos, txt, cls, map) {
    // Now initialize all properties.
    this.pos = pos;
    this.txt_ = txt;
    this.cls_ = cls;
    this.map_ = map;

    // We define a property to hold the image's
    // div. We'll actually create this div
    // upon receipt of the add() method so we'll
    // leave it null for now.
    this.div_ = null;

    // Explicitly call setMap() on this overlay
    this.setMap(map);
}
TxtOverlay.prototype = new google.maps.OverlayView();

TxtOverlay.prototype.onAdd = function () {
    // Note: an overlay's receipt of onAdd() indicates that
    // the map's panes are now available for attaching
    // the overlay to the map via the DOM.

    // Create the DIV and set some basic attributes.
    var div = document.createElement('DIV');
    div.className = this.cls_;

    div.innerHTML = this.txt_;

    // Set the overlay's div_ property to this DIV
    this.div_ = div;
    var overlayProjection = this.getProjection();
    var position = overlayProjection.fromLatLngToDivPixel(this.pos);
    div.style.left = position.x + 'px';
    div.style.top = position.y + 'px';
    // We add an overlay to a map via one of the map's panes.
    var panes = this.getPanes();
    panes.floatPane.appendChild(div);
};
TxtOverlay.prototype.draw = function () {
    var overlayProjection = this.getProjection();

    // Retrieve the southwest and northeast coordinates of this overlay
    // in latlngs and convert them to pixels coordinates.
    // We'll use these coordinates to resize the DIV.
    var position = overlayProjection.fromLatLngToDivPixel(this.pos);

    var div = this.div_;
    div.style.left = position.x + 'px';
    div.style.top = position.y + 'px';
};
TxtOverlay.prototype.onRemove = function () {
    this.div_.parentNode.removeChild(this.div_);
    this.div_ = null;
};
TxtOverlay.prototype.hide = function () {
    if (this.div_) {
        this.div_.style.visibility = "hidden";
    }
};
TxtOverlay.prototype.show = function () {
    if (this.div_) {
        this.div_.style.visibility = "visible";
    }
};
TxtOverlay.prototype.toggle = function () {
    if (this.div_) {
        if (this.div_.style.visibility == "hidden") {
            this.show();
        }
        else {
            this.hide();
        }
    }
};
TxtOverlay.prototype.toggleDOM = function () {
    if (this.getMap()) {
        this.setMap(null);
    }
    else {
        this.setMap(this.map_);
    }
};

function initialize() {
    var mapCanvas = document.getElementById('map-canvas');
    var mapOptions = {
        center: new google.maps.LatLng(59.956180, 30.318793),
        zoom: 13,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    var map = new google.maps.Map(mapCanvas, mapOptions);

    var image = '/pages/about/img/map-marker.png';
    var myLatLng = new google.maps.LatLng(59.956180, 30.318793);
    var beachMarker = new google.maps.Marker({
        position: myLatLng,
        map: map,
        icon: image
    });
    var LatLng = new google.maps.LatLng(59.965559, 30.220703);
    var customTxt = "<div><div class='left'><div class='email'><span></span><a href='mailto:job@orbitum.com'>job@orbitum.com</a></div><div class='phone'><span></span><p>7 812 454-03-96</p></div></div><div class='right'><span>г. Санкт-Петербург</span><span>ст. м. Горьковская</span></div></div>"
    var txt = new TxtOverlay(LatLng, customTxt, "customBox", map)
}

google.maps.event.addDomListener(window, 'load', initialize);