<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instant Delivery - Map</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
        }

        .form-container, .map-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            width: 400px;
            display: none;
        }

        h2 {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }

        .input-group {
            margin-bottom: 15px;
        }

        .input-group label {
            display: block;
            font-size: 16px;
            color: #555;
            margin-bottom: 5px;
        }

        .input-group input {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        .button-group {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .button-group button, .next-btn, .confirm-btn {
            width: 48%;
            padding: 12px;
            background-color: #0f506e;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
        }

        .button-group button:hover, .next-btn:hover, .confirm-btn:hover {
            background-color: #0d3c4c;
        }

        /* Map styling */
        #map {
            height: 300px;
            width: 100%;
            margin-top: 20px;
        }

        .next-btn, .confirm-btn {
            width: 100%;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<!-- Initial Form Container -->
<div class="form-container" id="form-container">
    <h2>Instant Delivery</h2>

    <div class="input-group">
        <label for="pickup">Pickup Location</label>
        <input type="text" id="pickup" placeholder="Enter Pickup Location">
    </div>

    <div class="input-group">
        <label for="destination">Destination</label>
        <input type="text" id="destination" placeholder="Enter Destination">
    </div>

    <button class="next-btn" onclick="showMap()">Next</button>
</div>

<!-- Map Container -->
<div class="map-container" id="map-container">
    <div id="map"></div>
    <button class="confirm-btn" onclick="confirmDestination()">Confirm Destination</button>
</div>

<!-- Leaflet.js library -->
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

<script>
// Initialize variables for map and markers
var map;
var pickupMarker, destinationMarker;
var pickupLocation, destinationLocation;

// Function to initialize the map
function initMap() {
    // Initialize the map at a default location (e.g., Dhaka)
    map = L.map('map').setView([23.8103, 90.4125], 12);

    // Set OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap'
    }).addTo(map);
}

// Function to search for a location using Nominatim (OpenStreetMap geocoding)
function searchLocation(location, callback) {
    var url = `https://nominatim.openstreetmap.org/search?format=json&q=${location}`;

    fetch(url)
        .then(response => response.json())
        .then(data => {
            if (data && data.length > 0) {
                var lat = data[0].lat;
                var lon = data[0].lon;
                callback([lat, lon]);
            } else {
                alert("Location not found!");
            }
        })
        .catch(error => {
            console.error('Error fetching location:', error);
            alert('Error searching for location.');
        });
}

// Set the pickup location
function searchPickup() {
    pickupLocation = document.getElementById('pickup').value;
    
    searchLocation(pickupLocation, function(latlng) {
        if (pickupMarker) {
            map.removeLayer(pickupMarker);  // Remove old marker
        }
        pickupMarker = L.marker(latlng).addTo(map).bindPopup("Pickup Location").openPopup();
        map.setView(latlng, 14);  // Center the map on the pickup location
    });
}

// Set the destination location
function searchDestination() {
    destinationLocation = document.getElementById('destination').value;

    searchLocation(destinationLocation, function(latlng) {
        if (destinationMarker) {
            map.removeLayer(destinationMarker);  // Remove old marker
        }
        destinationMarker = L.marker(latlng).addTo(map).bindPopup("Destination Location").openPopup();
        map.setView(latlng, 14);  // Center the map on the destination location
    });
}

// Function to show the map and hide the input form
function showMap() {
    // Search for both pickup and destination
    searchPickup();
    searchDestination();

    // Hide the form container and show the map container
    document.getElementById('form-container').style.display = 'none';
    document.getElementById('map-container').style.display = 'block';
    
    // Initialize the map if it's not already initialized
    if (!map) {
        initMap();
    }
}

// Function to confirm the destination and redirect to the next form page
function confirmDestination() {
    // Redirect to next page with pickup and destination as query parameters
    window.location.href = `parcel_info.php?pickup=${encodeURIComponent(pickupLocation)}&destination=${encodeURIComponent(destinationLocation)}`;
}

// Initialize the form when the page loads
window.onload = function() {
    document.getElementById('form-container').style.display = 'block';
    document.getElementById('map-container').style.display = 'none';
};

</script>

</body>
</html>
