<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Leaflet Map</title>
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
  
  <link rel="stylesheet" href="https://unpkg.com/leaflet-search/dist/leaflet-search.min.css" />
  <script src="https://unpkg.com/leaflet-search/dist/leaflet-search.min.js"></script>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXhW+ALEwIH" crossorigin="anonymous">
  <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/favicon.ico') }}" />
  <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="https://cdn.jsdelivr.net/npm/exceljs@4.3.0/dist/exceljs.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/PapaParse/5.3.0/papaparse.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/xlsx@0.17.0/dist/xlsx.full.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/xlsx/dist/xlsx.full.min.js"></script>
</head>

<body>
  <div class="container-fluid">
    <div class="map-wrapper">
      <div id="map"></div>
      <a href="javascript:history.back()" class="btn btn-light back-button">
        <i class="fa-solid fa-left-long"></i>
      </a>
      <label for="upload-csv" class="upload-button" title="Upload data">
        <i class="fa-solid fa-file-arrow-up"></i>
        <input type="file" id="upload-csv" accept=".csv" style="display: none;" />
      </label>
    <button id="download-xlsx" class="download-button" title="Download data">
      <i class="fa-solid fa-file-arrow-down"></i>
    </button>
    </div>
    <div class="sidebar">
      <div class="top-bar">
        <button class="home-button" onclick="redirectToMenu()">
          <i class="fa fa-home"></i>
        </button>
      </div>
      <form id="dataForm">
        <h2>Add Data</h2>
        <div class="input-group">
          <label for="customerName">Nama Customer</label>
          <input type="text" id="customerName" name="customerName" required>
        </div>
        <div class="input-group">
          <label for="address">Alamat</label>
          <input type="text" id="address" name="address" required>
        </div>
        <div class="input-group">
          <label for="latitude">Latitude</label>
          <input type="number" id="latitude" name="latitude" step="any" required>
        </div>
        <div class="input-group">
          <label for="longitude">Longitude</label>
          <input type="number" id="longitude" name="longitude" step="any" required>
        </div>
        <div class="input-group">
          <label for="type">Tipe Customer</label>
          <div class="radio-group">
            <input type="radio" id="indibiz" name="type" value="Indibiz" required>
            <label for="indibiz">Indibiz</label>
            <input type="radio" id="non-customer" name="type" value="Non-Customer" required>
            <label for="non-customer">Non-Customer</label>
          </div>
        </div>
        
        <div class="input-group" id="segmen-indibiz" style="display: none;">
          <label for="segmenIndibiz">Segmen Indibiz</label>
          <select id="segmenIndibiz" name="segmenIndibiz">
            <option value="Indibiz Sekolah">Indibiz Sekolah</option>
            <option value="Indibiz Ruko">Indibiz Ruko</option>
            <option value="Indibiz Hotel">Indibiz Hotel</option>
            <option value="Indibiz MultiFinance">Indibiz MultiFinance</option>
            <option value="Indibiz Health">Indibiz Health</option>
            <option value="Indibiz Ekspedisi">Indibiz Ekspedisi</option>
            <option value="Indibiz Energy">Indibiz Energy</option>
          </select>
        </div>
        
        <div class="input-group" id="segmen-non-customer" style="display: none;">
          <label for="segmenNonCustomer">Segmen Non-Customer</label>
          <select id="segmenNonCustomer" name="segmenNonCustomer">
            <option value="Sekolah">Sekolah</option>
            <option value="Ruko">Ruko</option>
            <option value="Hotel">Hotel</option>
            <option value="MultiFinance">MultiFinance</option>
            <option value="Health">Health</option>
            <option value="Ekspedisi">Ekspedisi</option>
            <option value="Energy">Energy</option>
          </select>
        </div>
        <div class="button-wrapper">
          <button type="submit" class="btn-submit">Tambah Marker</button>
        </div>

      </form>
      <button id="goals-plan-button" class="goals-plan-button">
        Goals Plan
      </button>
      <div id="goals-plan" class="goals-plan" style="display: none;">
        <h2>Goals Plan</h2>
        <div id="goals-plan-container" class="goals-plan-container">
          <!-- Daftar goals plan akan ditambahkan di sini oleh JavaScript -->
        </div>
        <button id="back-to-form-button" class="btn btn-secondary">Kembali ke Form</button>
      </div>
      
  <script>
    var osm = L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
      maxZoom: 19,
      attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
    });

    var CartoDB_Voyager = L.tileLayer(
      "https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png",
      {
        maxZoom: 19,
        attribution: '&copy; <a href="https://carto.com/attributions">CARTO</a>',
      }
    );

    var Esri_WorldImagery = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
        attribution: 'Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community'
      }
    );

    var Esri_Labels = L.tileLayer(
      "https://server.arcgisonline.com/ArcGIS/rest/services/Reference/World_Boundaries_and_Places/MapServer/tile/{z}/{y}/{x}", {
        attribution: 'Labels &copy; Esri'
      }
    );

    var Esri_WorldImagery_With_Labels = L.layerGroup([Esri_WorldImagery, Esri_Labels]);

    var map = L.map("map", {
        center: [-1.6097138916535554, 103.59584563774344],
        zoom: 13,
        layers: [
            L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            })
        ],
        attributionControl: false
    });

    var blueIcon = new L.Icon({
      iconUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-icon-2x.png',
      shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
      iconSize: [18, 31],
      iconAnchor: [10, 33],
      popupAnchor: [1, -28],
      shadowSize: [33, 33],
    });

    var redIcon = new L.Icon({
      iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-red.png',
      shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
      iconSize: [20, 33],
      iconAnchor: [10, 33],
      popupAnchor: [1, -28],
      shadowSize: [33, 33],
    });

    L.control.layers({
      "Default": osm,
      "Satellite": Esri_WorldImagery_With_Labels
    }).addTo(map);

    var markerGroup = L.layerGroup().addTo(map);

    function toggleSegmenOptions() {
        var type = document.querySelector('input[name="type"]:checked').value;
        var segmenIndibiz = document.getElementById('segmen-indibiz');
        var segmenNonCustomer = document.getElementById('segmen-non-customer');

        if (type === "Indibiz") {
            segmenIndibiz.style.display = 'block';
            segmenNonCustomer.style.display = 'none';
        } else if (type === "Non-Customer") {
            segmenIndibiz.style.display = 'none';
            segmenNonCustomer.style.display = 'block';
        }
    }

    
    document.addEventListener('DOMContentLoaded', function() {
  const radioButtons = document.querySelectorAll('input[name="type"]');
  const dataForm = document.getElementById('dataForm');

  radioButtons.forEach(radio => {
    radio.addEventListener('change', function() {
      dataForm.classList.add('form-expanded');
    });
  });
});

    document.getElementById('dataForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        var name = document.getElementById('customerName').value;
        var address = document.getElementById('address').value;
        var lat = parseFloat(document.getElementById('latitude').value);
        var lng = parseFloat(document.getElementById('longitude').value);
        var type = document.querySelector('input[name="type"]:checked').value;
        var segmen = (type === "Indibiz") ? document.getElementById('segmenIndibiz').value : document.getElementById('segmenNonCustomer').value;

        addMarker(name, lat, lng, address, type, segmen);
        saveData(name, lat, lng, address, type, segmen);
    });

    document.getElementById('goals-plan-button').addEventListener('click', function() {
    document.getElementById('dataForm').style.display = 'none';
    document.getElementById('goals-plan').style.display = 'block';
    loadGoalsPlan();
});




function loadGoalsPlan() {
    var markers = JSON.parse(localStorage.getItem('markers')) || [];
    var nonCustomerMarkers = markers.filter(marker => marker.type === 'Non-Customer');
    var goalsPlanContainer = document.getElementById('goals-plan-container');

    function renderMarkers(filteredMarkers) {
        goalsPlanContainer.innerHTML = ''; // Clear existing content

        filteredMarkers.forEach((marker, index) => {
            var item = document.createElement('div');
            item.className = 'goals-plan-item';
            item.dataset.index = index; // Set index to identify marker

            item.innerHTML = `
                <span class="marker-icon"><i class="fas fa-map-marker-alt"></i></span>
                <div class="info">
                    <div><strong>Nama</strong> ${marker.name}</div>
                    <div><strong>Koordinat</strong> ${marker.latitude}, ${marker.longitude}</div>
                    <div><strong>Alamat</strong> ${marker.address}</div>
                </div>
                <div class="actions">
                    <button class="btn-check"><i class="fas fa-check"></i></button>
                    <button class="btn-info"><i class="fas fa-info-circle"></i></button>
                </div>
            `;
            goalsPlanContainer.appendChild(item);

            // Add event listener for marker icon click
            item.querySelector('.marker-icon').addEventListener('click', function() {
                var markerData = filteredMarkers[index];
                var latlng = [markerData.latitude, markerData.longitude];
                map.setView(latlng, 15); // Set the view to the marker's location

                var markerOnMap = markerGroup.getLayers().find(m => m.getLatLng().equals(latlng));
                if (markerOnMap) {
                    markerOnMap.openPopup(); // Open popup if marker is already on the map
                }
            });
        });

        // Add event listeners to check buttons
        document.querySelectorAll('.btn-check').forEach(button => {
            button.addEventListener('click', () => {
                button.classList.toggle('active');
            });
        });
    }

    renderMarkers(nonCustomerMarkers);
}


    function addMarker(name, lat, lng, address, type, segmen) {
        var icon = (type === "Indibiz") ? blueIcon : redIcon;

        var marker = L.marker([lat, lng], { icon: icon, title: name })
        .bindPopup(
            `<div class='popup-content'>
                <div class='popup-item'><strong>Nama Tempat: </strong>${name}</div>
                <div class='popup-item'><strong>Alamat: </strong>${address}</div>
                <div class='popup-item'><strong>Koordinat: </strong>${lat}, ${lng}</div>
                <div class='popup-item'><strong>Tipe: </strong>${type}</div>
                <div class='popup-item'><strong>Segmen: </strong>${segmen}</div>
                <button class='btn-delete-marker'><i class='fas fa-trash-alt'></i></button>
            </div>`
        );

        marker.options.popupText = marker._popup._content;
        marker.on('popupopen', function() {
            var deleteButton = document.querySelector('.leaflet-popup .btn-delete-marker');
            deleteButton.addEventListener('click', function() {
                markerGroup.removeLayer(marker);
                removeMarkerFromStorage(name, lat, lng, address, type, segmen);
            });
        });
        marker.addTo(markerGroup);
    }

    function removeMarkerFromStorage(name, lat, lng, address, type, segmen) {
        var markers = JSON.parse(localStorage.getItem('markers')) || [];
        markers = markers.filter(marker =>
            !(marker.name === name &&
              marker.latitude === lat &&
              marker.longitude === lng &&
              marker.address === address &&
              marker.type === type &&
              marker.segmen === segmen)
        );
        localStorage.setItem('markers', JSON.stringify(markers));
    }

    function saveData(name, lat, lng, address, type, segmen) {
    let markers = JSON.parse(localStorage.getItem('markers')) || [];
    markers.push({ name, latitude: lat, longitude: lng, address, type, segmen });
    localStorage.setItem('markers', JSON.stringify(markers));
}


    function loadMarkers() {
        var markers = JSON.parse(localStorage.getItem('markers')) || [];
        markers.forEach(function(marker) {
            addMarker(marker.name, marker.latitude, marker.longitude, marker.address, marker.type, marker.segmen);
        });
    }

    loadMarkers();

    function redirectToMenu() {
        window.location.href = '{{ url("/menu") }}';
    }

    L.control.search({
        layer: markerGroup,
        initial: false,
        propertyName: 'title',
        marker: false,
        moveToLocation: function(latlng, title, map) {
            map.setView(latlng, 15);
            var marker = markerGroup.getLayers().find(m => m.options.title === title);
            if (marker) {
                marker.openPopup();
            }
        }
    }).addTo(map);

    document.addEventListener('DOMContentLoaded', function () {
        const indibizRadio = document.getElementById('indibiz');
        const nonCustomerRadio = document.getElementById('non-customer');
        const segmenIndibiz = document.getElementById('segmen-indibiz');
        const segmenNonCustomer = document.getElementById('segmen-non-customer');

        function handleTypeChange() {
            if (indibizRadio.checked) {
                segmenIndibiz.style.display = 'block';
                segmenNonCustomer.style.display = 'none';
            } else if (nonCustomerRadio.checked) {
                segmenIndibiz.style.display = 'none';
                segmenNonCustomer.style.display = 'block';
            }
        }

        indibizRadio.addEventListener('change', handleTypeChange);
        nonCustomerRadio.addEventListener('change', handleTypeChange);

        handleTypeChange();
    });

    map.on('click', function(e) {
        var lat = e.latlng.lat;
        var lng = e.latlng.lng;
        document.getElementById('latitude').value = lat;
        document.getElementById('longitude').value = lng;
    });

    // Fungsi untuk membaca file CSV dan menambahkan marker
    document.getElementById('upload-csv').addEventListener('change', function(event) {
        var file = event.target.files[0];
        Papa.parse(file, {
            header: true,
            dynamicTyping: true,
            complete: function(results) {
                clearMarkers(); // Hapus semua marker lama sebelum menambahkan yang baru

                var markers = results.data.filter(row => row.latitude && row.longitude);
                
                markers = markers.map(marker => {
                    return {
                        name: marker.name ? marker.name.trim() : 'Unknown',
                        latitude: marker.latitude,
                        longitude: marker.longitude,
                        address: marker.address ? marker.address.trim() : 'No Address',
                        type: marker.type ? marker.type.trim() : 'Unknown',
                        segmen: marker.segmen ? marker.segmen.trim() : 'No Segment'
                    };
                });

                markers.forEach(function(row) {
                    addMarker(row.name, row.latitude, row.longitude, row.address, row.type, row.segmen);
                    saveData(row.name, row.latitude, row.longitude, row.address, row.type, row.segmen);
                });
            }
        });
    });

    function clearMarkers() {
        markerGroup.clearLayers();
        localStorage.removeItem('markers');
    }
    // Fungsi untuk mengunduh marker sebagai file XLSX
    document.getElementById('download-xlsx').addEventListener('click', async function() {
      var markers = JSON.parse(localStorage.getItem('markers')) || [];
      if (markers.length === 0) {
          alert('Tidak ada data untuk diunduh.');
          return;
      }

      const workbook = new ExcelJS.Workbook();
      const worksheet = workbook.addWorksheet('Markers');

      // Define header row
      worksheet.columns = [
          { header: 'Nama', key: 'name', width: 20 },
          { header: 'Latitude', key: 'latitude', width: 15 },
          { header: 'Longitude', key: 'longitude', width: 15 },
          { header: 'Alamat', key: 'address', width: 30 },
          { header: 'Tipe', key: 'type', width: 15 },
          { header: 'Segmen', key: 'segmen', width: 20 },
      ];

      // Add rows to worksheet
      markers.forEach(marker => {
          worksheet.addRow(marker);
      });

      // Style header row
      worksheet.getRow(1).font = { bold: true, color: { argb: 'FFFFFF' } };
      worksheet.getRow(1).fill = {
          type: 'pattern',
          pattern: 'solid',
          fgColor: { argb: '0000FF' }
      };

      // Add borders to all cells
      worksheet.eachRow({ includeEmpty: true }, function(row, rowNumber) {
          row.eachCell({ includeEmpty: true }, function(cell, colNumber) {
              cell.border = {
                  top: { style: 'thin', color: { argb: '000000' } },
                  left: { style: 'thin', color: { argb: '000000' } },
                  bottom: { style: 'thin', color: { argb: '000000' } },
                  right: { style: 'thin', color: { argb: '000000' } }
              };
          });
      });

      // Save the file
      const buffer = await workbook.xlsx.writeBuffer();
      const blob = new Blob([buffer], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
      const url = window.URL.createObjectURL(blob);
      const a = document.createElement('a');
      a.href = url;
      a.download = 'Informasi_pelanggan.xlsx';
      a.click();
      window.URL.revokeObjectURL(url);
  });

// Misalnya tombol di dalam goals plan untuk kembali ke form
document.getElementById('goals-plan-button').addEventListener('click', function() {
  document.getElementById('dataForm').style.display = 'none';
  document.getElementById('goals-plan').style.display = 'block';
  document.getElementById('goals-plan-button').style.display = 'none'; 
  loadGoalsPlan(); // Pastikan ini memuat goals plan dari local storage
});

document.getElementById('back-to-form-button').addEventListener('click', function() {
  document.getElementById('dataForm').style.display = 'block';
  document.getElementById('goals-plan').style.display = 'none';
  document.getElementById('goals-plan-button').style.display = 'block';
});

  </script>
</body>
</html>
