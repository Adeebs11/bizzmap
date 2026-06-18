<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Leaflet Map</title>
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
  <link rel="stylesheet" href="https://unpkg.com/leaflet-search/dist/leaflet-search.min.css" />
  <script src="https://unpkg.com/leaflet-search/dist/leaflet-search.min.js"></script>
  <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/favicon.ico') }}" />
  <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="https://cdn.jsdelivr.net/npm/exceljs@4.3.0/dist/exceljs.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/PapaParse/5.3.0/papaparse.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/xlsx@0.17.0/dist/xlsx.full.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/xlsx/dist/xlsx.full.min.js"></script>

  <style>
    /* ============================================================
       Sidebar Redesign — geo.blade.php
       ============================================================ */

    /* Override sidebar layout */
    .sidebar {
      padding: 0 !important;
      overflow-y: hidden !important;
      justify-content: flex-start !important;
    }

    /* Sidebar header bar */
    .sidebar-header {
      background: linear-gradient(135deg, #C02016, #E8453C);
      padding: 11px 14px;
      display: flex;
      align-items: center;
      gap: 10px;
      flex-shrink: 0;
    }
    .home-btn-sidebar {
      background: rgba(255,255,255,0.20);
      border: 1px solid rgba(255,255,255,0.30);
      color: white;
      cursor: pointer;
      padding: 5px 9px;
      border-radius: 7px;
      font-size: 13px;
      transition: background 0.2s;
      line-height: 1;
    }
    .home-btn-sidebar:hover { background: rgba(255,255,255,0.35); }
    .sidebar-title-text {
      color: white;
      font-size: 14.5px;
      font-weight: 600;
      letter-spacing: 0.2px;
      display: flex;
      align-items: center;
      gap: 7px;
    }

    /* Scrollable area inside sidebar */
    .sidebar-scroll-area {
      flex: 1;
      overflow-y: auto;
      padding: 12px 12px 70px 12px;
    }
    .sidebar-scroll-area::-webkit-scrollbar { width: 4px; }
    .sidebar-scroll-area::-webkit-scrollbar-track { background: #f1f1f1; }
    .sidebar-scroll-area::-webkit-scrollbar-thumb { background: #ddd; border-radius: 2px; }

    /* Form override */
    #dataForm {
      background: transparent !important;
      border: none !important;
      padding: 0 !important;
      margin-bottom: 0 !important;
    }

    /* Form sections */
    .form-section {
      background: #fff;
      border: 1px solid #F0F0F0;
      border-radius: 10px;
      padding: 11px 13px 13px;
      margin-bottom: 10px;
      box-shadow: 0 1px 4px rgba(0,0,0,0.04);
    }
    .section-label {
      font-size: 10px;
      font-weight: 700;
      color: #C02016;
      text-transform: uppercase;
      letter-spacing: 0.9px;
      margin-bottom: 9px;
      padding-bottom: 7px;
      border-bottom: 1.5px solid #FFEBE9;
    }

    /* Field group overrides */
    #dataForm .field-group {
      margin-bottom: 8px;
    }
    #dataForm .field-group:last-child { margin-bottom: 0; }
    #dataForm .field-group label {
      display: block;
      font-size: 12px;
      font-weight: 500;
      color: #444;
      margin-bottom: 4px;
    }
    #dataForm .field-group input,
    #dataForm .field-group select {
      width: 100%;
      padding: 7px 10px;
      border: 1.5px solid #E0E0E0;
      border-radius: 8px;
      font-size: 12.5px;
      font-family: 'Poppins', sans-serif;
      color: #333;
      background: #fff;
      transition: border-color 0.2s, box-shadow 0.2s;
      margin-bottom: 0;
      box-sizing: border-box;
    }
    #dataForm .field-group input::placeholder {
      color: #AAAAAA;
      font-style: italic;
      font-weight: 400;
      opacity: 1;
    }
    #dataForm .field-group input:focus,
    #dataForm .field-group select:focus {
      border-color: #C02016;
      box-shadow: 0 0 0 3px rgba(192,32,22,0.12);
      outline: none;
    }
    /* Error state */
    #dataForm .field-group input.field-error {
      border-color: #E53935;
      box-shadow: 0 0 0 3px rgba(229,57,53,0.12);
    }
    .field-error-msg {
      font-size: 11px;
      color: #E53935;
      margin-top: 3px;
      display: none;
    }

    .req { color: #C02016; font-size: 11px; }

    /* Lat/lng row */
    .row-fields {
      display: flex;
      gap: 8px;
    }
    .row-fields .field-group { flex: 1; }

    /* Type pills */
    .type-pills {
      display: flex;
      gap: 7px;
    }
    .pill-radio { display: none !important; }
    .pill-label {
      flex: 1;
      text-align: center;
      padding: 6px 10px;
      border-radius: 20px;
      background: #F0F0F0;
      color: #666;
      cursor: pointer;
      font-size: 12px;
      font-weight: 500;
      font-family: 'Poppins', sans-serif;
      transition: background 0.2s, color 0.2s, box-shadow 0.2s;
      border: 1.5px solid transparent;
      user-select: none;
    }
    .pill-radio:checked + .pill-label {
      background: #C02016;
      color: white;
      border-color: #C02016;
      box-shadow: 0 2px 8px rgba(192,32,22,0.25);
    }

    /* Langganan section slide animation */
    .langganan-section {
      max-height: 0;
      overflow: hidden;
      padding-top: 0;
      padding-bottom: 0;
      border-color: transparent;
      box-shadow: none;
      margin-bottom: 0;
      transition: max-height 0.35s ease, padding 0.25s ease,
                  border-color 0.2s, margin-bottom 0.25s ease;
    }
    .langganan-section.visible {
      max-height: 160px;
      padding-top: 11px;
      padding-bottom: 13px;
      border-color: #F0F0F0;
      box-shadow: 0 1px 4px rgba(0,0,0,0.04);
      margin-bottom: 10px;
    }

    /* Submit button */
    #dataForm .button-wrapper { margin-top: 4px; }
    .btn-submit {
      width: 100%;
      height: 44px;
      border-radius: 8px;
      background: linear-gradient(135deg, #C02016, #E8453C);
      color: white;
      border: none;
      font-size: 13.5px;
      font-weight: 600;
      font-family: 'Poppins', sans-serif;
      cursor: pointer;
      transition: transform 0.15s, box-shadow 0.15s, background 0.2s;
      padding: 0 20px;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      margin-top: 0;
    }
    .btn-submit:hover:not(:disabled) {
      background: linear-gradient(135deg, #a01812, #C02016);
      transform: translateY(-1px);
      box-shadow: 0 4px 14px rgba(192,32,22,0.35);
    }
    .btn-submit:disabled {
      opacity: 0.72;
      cursor: not-allowed;
      transform: none;
    }

    /* Popup redesign */
    .leaflet-popup-content-wrapper {
      border-radius: 10px !important;
      padding: 0 !important;
      overflow: hidden;
      box-shadow: 0 4px 20px rgba(0,0,0,0.18) !important;
    }
    .leaflet-popup-content {
      margin: 0 !important;
      width: 260px !important;
    }
    .popup-header {
      background: linear-gradient(135deg, #C02016, #E8453C);
      color: white;
      padding: 9px 13px;
      font-weight: 600;
      font-size: 13px;
      line-height: 1.35;
      word-break: break-word;
    }
    .popup-body {
      padding: 10px 13px;
      font-size: 12px;
      color: #333;
      font-family: 'Poppins', sans-serif;
    }
    .popup-row {
      display: flex;
      align-items: flex-start;
      gap: 7px;
      margin-bottom: 6px;
    }
    .popup-row:last-child { margin-bottom: 0; }
    .popup-row i {
      color: #C02016;
      width: 13px;
      text-align: center;
      flex-shrink: 0;
      margin-top: 1px;
      font-size: 11px;
    }
    .popup-row .popup-label {
      color: #999;
      font-size: 10px;
      display: block;
      line-height: 1.2;
    }
    .popup-row .popup-value {
      color: #333;
      font-weight: 500;
      line-height: 1.3;
      word-break: break-word;
    }
    .popup-type-badge {
      display: inline-block;
      padding: 1px 8px;
      border-radius: 10px;
      font-size: 10.5px;
      font-weight: 600;
      margin-top: 1px;
    }
    .popup-type-customer { background: #E3F2FD; color: #1565C0; }
    .popup-type-non { background: #FFE5E3; color: #C02016; }

    /* Toast redesign */
    .toast-redesigned {
      background: white !important;
      border-radius: 10px !important;
      border: none !important;
      box-shadow: 0 4px 20px rgba(0,0,0,0.15) !important;
      min-width: 280px;
    }
    .toast-inner {
      display: flex;
      align-items: center;
      padding: 12px 14px;
      gap: 10px;
    }
    .toast-icon-wrap { font-size: 19px; flex-shrink: 0; line-height: 1; }
    .toast-msg {
      flex: 1;
      font-size: 12.5px;
      color: #333;
      font-weight: 500;
      font-family: 'Poppins', sans-serif;
      line-height: 1.4;
    }
    .toast-dismiss { flex-shrink: 0; filter: invert(1) brightness(0.3); }

    /* ========================
       Kecamatan Layer (GeoJSON)
       ======================== */
    .kecamatan-label {
      background:     transparent !important;
      border:         none !important;
      box-shadow:     none !important;
      font-family:    'Poppins', sans-serif !important;
      font-size:      10px !important;
      font-weight:    700 !important;
      color:          #222222 !important;
      text-transform: uppercase !important;
      letter-spacing: 0.4px !important;
      white-space:    nowrap !important;
      pointer-events: none !important;
      text-shadow:
        -1px -1px 0 rgba(255,255,255,0.95),
         1px -1px 0 rgba(255,255,255,0.95),
        -1px  1px 0 rgba(255,255,255,0.95),
         1px  1px 0 rgba(255,255,255,0.95) !important;
    }
    /* Marker & popup selalu di atas layer kecamatan */
    .leaflet-marker-pane  { z-index: 620 !important; }
    .leaflet-popup-pane   { z-index: 700 !important; }
    .leaflet-tooltip-pane { z-index: 650 !important; }

    /* Toggle button kecamatan */
    #btnKecamatan {
      padding: 5px 12px;
      border: 1.5px solid #C02016;
      border-radius: 16px;
      background: white;
      color: #C02016;
      font-family: 'Poppins', sans-serif;
      font-size: 11.5px;
      font-weight: 500;
      cursor: pointer;
      transition: all 0.2s;
      position: absolute;
      bottom: 60px;
      right: 60px;
      z-index: 1000;
      box-shadow: 0 2px 6px rgba(0,0,0,0.12);
      display: flex;
      align-items: center;
      gap: 5px;
    }
    #btnKecamatan:hover { background: #FFF0EF; }
  </style>
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
      <button id="btnKecamatan" title="Tampilkan/sembunyikan batas kecamatan">
        🗺️ Batas Kecamatan
      </button>
    </div>

    <div class="sidebar">
      <!-- Header bar -->
      <div class="sidebar-header">
        <button class="home-btn-sidebar" onclick="redirectToMenu()" title="Kembali ke Menu">
          <i class="fa fa-home"></i>
        </button>
        <div class="sidebar-title-text">
          <i class="fa-solid fa-map-pin"></i>
          Tambah Lokasi
        </div>
      </div>

      <!-- Scrollable content area -->
      <div class="sidebar-scroll-area">

        <form id="dataForm">

          <!-- Section 1: Informasi Lokasi -->
          <div class="form-section">
            <div class="section-label">📍 Informasi Lokasi</div>
            <div class="field-group">
              <label for="customerName">Nama Customer <span class="req">*</span></label>
              <input type="text" id="customerName" name="customerName" placeholder="Nama bisnis / pelanggan" required>
              <div class="field-error-msg" id="err-customerName"></div>
            </div>
            <div class="field-group">
              <label for="address">Alamat <span class="req">*</span></label>
              <input type="text" id="address" name="address" placeholder="Jalan, nomor, kelurahan" required>
              <div class="field-error-msg" id="err-address"></div>
            </div>
            <div class="row-fields">
              <div class="field-group">
                <label for="latitude">Latitude <span class="req">*</span></label>
                <input type="number" id="latitude" name="latitude" step="any" placeholder="Klik peta" required>
              </div>
              <div class="field-group">
                <label for="longitude">Longitude <span class="req">*</span></label>
                <input type="number" id="longitude" name="longitude" step="any" placeholder="Klik peta" required>
              </div>
            </div>
            <div class="field-error-msg" id="err-coords"></div>
          </div>

          <!-- Section 2: Data Pemilik -->
          <div class="form-section">
            <div class="section-label">👤 Data Pemilik</div>
            <div class="field-group">
              <label for="ownerName">Nama Pemilik</label>
              <input type="text" id="ownerName" name="ownerName" placeholder="Nama pemilik / penanggungjawab">
            </div>
            <div class="field-group">
              <label for="phone">No. Telepon</label>
              <input type="text" id="phone" name="phone" placeholder="08xx-xxxx-xxxx">
            </div>
          </div>

          <!-- Section 3: Detail Bisnis -->
          <div class="form-section">
            <div class="section-label">🏢 Detail Bisnis</div>
            <div class="field-group">
              <label for="businessDetail">Bidang Bisnis</label>
              <input type="text" id="businessDetail" name="businessDetail" placeholder="Contoh: ritel makanan, jasa logistik">
            </div>
            <div class="field-group">
              <label for="omset">Omset per Bulan</label>
              <select id="omset" name="omset">
                <option value="">-- Pilih Omset --</option>
                <option value="di_bawah_5jt">Di Bawah Rp 5 Juta</option>
                <option value="5jt_20jt">Rp 5 – 20 Juta</option>
                <option value="20jt_50jt">Rp 20 – 50 Juta</option>
                <option value="50jt_100jt">Rp 50 – 100 Juta</option>
                <option value="di_atas_100jt">Di Atas Rp 100 Juta</option>
              </select>
            </div>
            <div class="field-group">
              <label>Tipe Customer <span class="req">*</span></label>
              <div class="type-pills">
                <input type="radio" id="indibiz" name="type" value="Indibiz" class="pill-radio" required>
                <label for="indibiz" class="pill-label">Indibiz</label>
                <input type="radio" id="non-customer" name="type" value="Non-Customer" class="pill-radio">
                <label for="non-customer" class="pill-label">Non-Customer</label>
              </div>
              <div class="field-error-msg" id="err-type"></div>
            </div>
            <div class="field-group" id="segmen-indibiz" style="display: none;">
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
            <div class="field-group" id="segmen-non-customer" style="display: none;">
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
          </div>

          <!-- Section 4: Langganan (slide-in when Indibiz) -->
          <div class="form-section langganan-section" id="langganan-section">
            <div class="section-label">📦 Langganan</div>
            <div class="field-group">
              <label for="paketLangganan">Paket Langganan</label>
              <input type="text" id="paketLangganan" name="paketLangganan" placeholder="Contoh: IndiHome 20 Mbps">
            </div>
          </div>

          <div class="button-wrapper">
            <button type="submit" id="submitBtn" class="btn-submit">
              <span id="submitBtnContent">
                <i class="fa-solid fa-paper-plane"></i> Kirim Data
              </span>
              <span id="submitBtnLoading" style="display:none;">
                <i class="fa-solid fa-spinner fa-spin"></i> Mengirim...
              </span>
            </button>
          </div>

        </form>

        <!-- Goals Plan Panel -->
        <div id="goals-plan" class="goals-plan" style="display: none;">
          <h2>Goals Plan</h2>
          <div id="goals-plan-container" class="goals-plan-container"></div>
          <button id="back-to-form-button" class="btn btn-secondary">Kembali ke Form</button>
        </div>

      </div><!-- /.sidebar-scroll-area -->

      <button id="goals-plan-button" class="goals-plan-button">Goals Plan</button>

      <!-- Toast notification -->
      <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 3000;">
        <div id="submitToast" class="toast toast-redesigned" role="alert" aria-live="assertive" aria-atomic="true">
          <div class="toast-inner">
            <div class="toast-icon-wrap" id="toastIconWrap"></div>
            <div class="toast-msg" id="submitToastMsg">Pesan...</div>
            <button type="button" class="btn-close toast-dismiss" data-bs-dismiss="toast" aria-label="Close"></button>
          </div>
        </div>
      </div>

    </div><!-- /.sidebar -->
  </div><!-- /.container-fluid -->

  <script>
    /* ========================
       Map & Tile Layers
       ======================== */
    var osm = L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
      maxZoom: 19,
      attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
    });

    var CartoDB_Voyager = L.tileLayer(
      "https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png",
      { maxZoom: 19, attribution: '&copy; <a href="https://carto.com/attributions">CARTO</a>' }
    );

    var Esri_WorldImagery = L.tileLayer(
      'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}',
      { attribution: 'Tiles &copy; Esri' }
    );

    var Esri_Labels = L.tileLayer(
      "https://server.arcgisonline.com/ArcGIS/rest/services/Reference/World_Boundaries_and_Places/MapServer/tile/{z}/{y}/{x}",
      { attribution: 'Labels &copy; Esri' }
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
      iconSize: [18, 31], iconAnchor: [10, 33], popupAnchor: [1, -28], shadowSize: [33, 33],
    });

    var redIcon = new L.Icon({
      iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-red.png',
      shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
      iconSize: [20, 33], iconAnchor: [10, 33], popupAnchor: [1, -28], shadowSize: [33, 33],
    });

    L.control.layers({
      "Default": osm,
      "Satellite": Esri_WorldImagery_With_Labels
    }).addTo(map);

    var markerGroup = L.layerGroup().addTo(map);

    /* ===================================
       Layer Batas Kecamatan (GeoJSON)
       =================================== */
    var warnaKecamatan = {
      'DANAUTELUK':    '#E67E22',
      'JALUTUNG':      '#27AE60',
      'JAMBI SELATAN': '#8E44AD',
      'JAMBI TIMUR':   '#F39C12',
      'KOTABARU':      '#BDC3C7',
      'PASAR JAMBI':   '#3498DB',
      'PELAYANGAN':    '#1ABC9C',
      'TELANAIPURA':   '#E74C3C'
    };

    var namaRapi = {
      'DANAUTELUK':    'Danau Teluk',
      'JALUTUNG':      'Jelutung',
      'JAMBI SELATAN': 'Jambi Selatan',
      'JAMBI TIMUR':   'Jambi Timur',
      'KOTABARU':      'Kota Baru',
      'PASAR JAMBI':   'Pasar Jambi',
      'PELAYANGAN':    'Pelayangan',
      'TELANAIPURA':   'Telanaipura'
    };

    var kecamatanGeoJson = null;
    var kecamatanVisible = true;

    function initKecamatan() {
      fetch('{{ asset("geojson/kecamatan-kota-jambi.json") }}')
        .then(function (res) {
          if (!res.ok) throw new Error('File GeoJSON tidak ditemukan');
          return res.json();
        })
        .then(function (data) {
          kecamatanGeoJson = L.geoJSON(data, {

            style: function (feature) {
              var kode = (feature.properties.NAMOBJ || '').toUpperCase().trim();
              return {
                color:        '#444444',
                weight:       2,
                opacity:      0.9,
                fillColor:    warnaKecamatan[kode] || '#CCCCCC',
                fillOpacity:  0.20,
                smoothFactor: 1.5
              };
            },

            onEachFeature: function (feature, layer) {
              var kode  = (feature.properties.NAMOBJ || '').toUpperCase().trim();
              var nama  = namaRapi[kode] || feature.properties.NAMOBJ;
              var warna = warnaKecamatan[kode] || '#CCCCCC';

              layer.bindTooltip(nama, {
                permanent:  true,
                direction:  'center',
                className:  'kecamatan-label'
              });

              layer.on('mouseover', function () {
                layer.setStyle({ fillOpacity: 0.40, weight: 2.5, color: '#C02016' });
                layer.bringToFront();
                if (markerGroup) markerGroup.bringToFront();
              });

              layer.on('mouseout', function () {
                kecamatanGeoJson.resetStyle(layer);
                layer.bringToBack();
              });

              layer.on('click', function (e) {
                L.popup({ maxWidth: 220 })
                  .setLatLng(e.latlng)
                  .setContent(
                    '<div style="font-family:Poppins;padding:6px 4px;">' +
                    '<div style="display:flex;align-items:center;gap:8px;">' +
                    '<div style="width:14px;height:14px;border-radius:4px;background:' + warna +
                    ';flex-shrink:0;"></div>' +
                    '<b style="font-size:13px;color:#111;">Kec. ' + nama + '</b>' +
                    '</div>' +
                    '<div style="color:#777;font-size:11px;margin-top:4px;padding-left:22px;">' +
                    'Kota Jambi · Provinsi Jambi</div>' +
                    '</div>'
                  )
                  .openOn(map);
                L.DomEvent.stopPropagation(e);
              });
            }

          }).addTo(map);

          kecamatanGeoJson.bringToBack();
          console.log('Kecamatan berhasil dimuat:', data.features.length, 'wilayah');
        })
        .catch(function (err) {
          console.warn('Gagal load kecamatan:', err.message);
        });
    }

    function toggleKecamatan() {
      var btn = document.getElementById('btnKecamatan');
      if (!kecamatanGeoJson) return;
      if (kecamatanVisible) {
        map.removeLayer(kecamatanGeoJson);
        btn.style.background  = '#f0f0f0';
        btn.style.color       = '#999';
        btn.style.borderColor = '#ddd';
        kecamatanVisible = false;
      } else {
        kecamatanGeoJson.addTo(map);
        kecamatanGeoJson.bringToBack();
        btn.style.background  = 'white';
        btn.style.color       = '#C02016';
        btn.style.borderColor = '#C02016';
        kecamatanVisible = true;
      }
    }

    document.getElementById('btnKecamatan').addEventListener('click', toggleKecamatan);

    initKecamatan();

    /* ========================
       Type / Segment Mapping
       ======================== */
    function mapUiTypeToDb(uiType) {
      return uiType === 'Indibiz' ? 'customer' : 'non_customer';
    }

    function mapUiSegmentToDb(uiType, uiSegment) {
      let s = uiSegment.toLowerCase();
      s = s.replace('indibiz ', '');
      s = s.replace('multi finance', 'multifinance');
      if (s.includes('sekolah'))     return 'sekolah';
      if (s.includes('ruko'))        return 'ruko';
      if (s.includes('hotel'))       return 'hotel';
      if (s.includes('multifinance'))return 'multifinance';
      if (s.includes('health'))      return 'health';
      if (s.includes('ekspedisi'))   return 'ekspedisi';
      if (s.includes('energy'))      return 'energi';
      return 'ruko';
    }

    function mapDbTypeToUi(dbType) {
      return dbType === 'customer' ? 'Indibiz' : 'Non-Customer';
    }

    function mapDbSegmentToUi(dbType, dbSegment) {
      const labelMap = {
        sekolah: 'Sekolah', ruko: 'Ruko', hotel: 'Hotel',
        multifinance: 'MultiFinance', health: 'Health',
        ekspedisi: 'Ekspedisi', energi: 'Energy',
      };
      const base = labelMap[dbSegment] ?? 'Ruko';
      return dbType === 'customer' ? `Indibiz ${base}` : base;
    }

    const omsetLabels = {
      'di_bawah_5jt':  'Di Bawah Rp 5 Juta',
      '5jt_20jt':      'Rp 5–20 Juta',
      '20jt_50jt':     'Rp 20–50 Juta',
      '50jt_100jt':    'Rp 50–100 Juta',
      'di_atas_100jt': 'Di Atas Rp 100 Juta',
    };
    function omsetLabel(val) { return omsetLabels[val] || val; }

    /* ========================
       Type Change Handler
       ======================== */
    function handleTypeChange() {
      const indibizChecked  = document.getElementById('indibiz').checked;
      const segmenIndibiz   = document.getElementById('segmen-indibiz');
      const segmenNonCust   = document.getElementById('segmen-non-customer');
      const langgananSection = document.getElementById('langganan-section');

      if (indibizChecked) {
        segmenIndibiz.style.display  = 'block';
        segmenNonCust.style.display  = 'none';
        langgananSection.classList.add('visible');
      } else {
        segmenIndibiz.style.display  = 'none';
        segmenNonCust.style.display  = 'block';
        langgananSection.classList.remove('visible');
      }
    }

    document.addEventListener('DOMContentLoaded', function () {
      document.getElementById('indibiz').addEventListener('change', handleTypeChange);
      document.getElementById('non-customer').addEventListener('change', handleTypeChange);
      handleTypeChange();
    });

    /* ========================
       Map Click → Fill Coords
       ======================== */
    map.on('click', function (e) {
      document.getElementById('latitude').value  = e.latlng.lat;
      document.getElementById('longitude').value = e.latlng.lng;
    });

    /* ========================
       Toast / Notification
       ======================== */
    function showSubmitPopup(message, type = 'success') {
      const toastEl  = document.getElementById('submitToast');
      const msgEl    = document.getElementById('submitToastMsg');
      const iconWrap = document.getElementById('toastIconWrap');

      if (!toastEl || !msgEl) { alert(message); return; }

      msgEl.textContent = message;

      const iconMap = {
        success: '<i class="fa-solid fa-circle-check" style="color:#28a745"></i>',
        danger:  '<i class="fa-solid fa-circle-xmark" style="color:#dc3545"></i>',
        warning: '<i class="fa-solid fa-triangle-exclamation" style="color:#ffc107"></i>',
        info:    '<i class="fa-solid fa-circle-info" style="color:#0dcaf0"></i>',
      };
      iconWrap.innerHTML = iconMap[type] || iconMap.success;

      if (typeof bootstrap === 'undefined' || !bootstrap.Toast) { alert(message); return; }
      new bootstrap.Toast(toastEl, { delay: 4000 }).show();
    }

    /* ========================
       Submit Button State
       ======================== */
    function setSubmitLoading(loading) {
      const btn     = document.getElementById('submitBtn');
      const content = document.getElementById('submitBtnContent');
      const spinner = document.getElementById('submitBtnLoading');
      btn.disabled         = loading;
      content.style.display = loading ? 'none' : 'inline-flex';
      spinner.style.display = loading ? 'inline-flex' : 'none';
    }

    /* ========================
       Field Error Helpers
       ======================== */
    function setFieldError(inputId, errId, msg) {
      const input = document.getElementById(inputId);
      const err   = document.getElementById(errId);
      if (!input || !err) return;
      if (msg) {
        input.classList.add('field-error');
        err.textContent  = msg;
        err.style.display = 'block';
      } else {
        input.classList.remove('field-error');
        err.style.display = 'none';
      }
    }
    function clearAllErrors() {
      ['customerName','address'].forEach(id => {
        const el = document.getElementById(id);
        if (el) el.classList.remove('field-error');
      });
      document.querySelectorAll('.field-error-msg').forEach(el => {
        el.style.display = 'none';
      });
    }

    /* ========================
       Form Submit
       ======================== */
    document.getElementById('dataForm').addEventListener('submit', async function (e) {
      e.preventDefault();
      clearAllErrors();

      const name    = document.getElementById('customerName').value?.trim();
      const address = document.getElementById('address').value?.trim();
      const lat     = parseFloat(document.getElementById('latitude').value);
      const lng     = parseFloat(document.getElementById('longitude').value);
      const typeEl  = document.querySelector('input[name="type"]:checked');
      const type    = typeEl ? typeEl.value : null;
      const segmen  = type === 'Indibiz'
        ? document.getElementById('segmenIndibiz').value
        : document.getElementById('segmenNonCustomer').value;

      // Field-level validation
      let hasError = false;
      if (!name)              { setFieldError('customerName','err-customerName','Nama customer wajib diisi.'); hasError = true; }
      if (!address)           { setFieldError('address','err-address','Alamat wajib diisi.'); hasError = true; }
      if (Number.isNaN(lat) || Number.isNaN(lng)) {
        const errCoords = document.getElementById('err-coords');
        if (errCoords) { errCoords.textContent = 'Klik peta untuk mengisi koordinat.'; errCoords.style.display = 'block'; }
        hasError = true;
      }
      if (!type) {
        const errType = document.getElementById('err-type');
        if (errType) { errType.textContent = 'Pilih tipe customer.'; errType.style.display = 'block'; }
        hasError = true;
      }
      if (hasError) return;

      // Extra fields (all optional)
      const extra = {
        owner_name:      document.getElementById('ownerName').value?.trim()        || null,
        phone:           document.getElementById('phone').value?.trim()            || null,
        business_detail: document.getElementById('businessDetail').value?.trim()   || null,
        omset:           document.getElementById('omset').value                    || null,
        paket_langganan: document.getElementById('paketLangganan').value?.trim()   || null,
      };

      setSubmitLoading(true);
      await saveData(name, lat, lng, address, type, segmen, extra);
      setSubmitLoading(false);
    });

    /* ========================
       Save Data (POST to DB)
       ======================== */
    async function saveData(name, lat, lng, address, type, segmen, extra = {}) {
      try {
        const csrf    = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const dbType  = mapUiTypeToDb(type);
        const dbSeg   = mapUiSegmentToDb(type, segmen);

        const payload = {
          name:            name,
          address:         address,
          latitude:        lat,
          longitude:       lng,
          type:            dbType,
          segment:         dbSeg,
          owner_name:      extra.owner_name      ?? null,
          phone:           extra.phone           ?? null,
          business_detail: extra.business_detail ?? null,
          omset:           extra.omset           ?? null,
          paket_langganan: extra.paket_langganan ?? null,
        };

        const res = await fetch("{{ route('locations.store') }}", {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrf,
            'Accept': 'application/json'
          },
          body: JSON.stringify(payload)
        });

        if (!res.ok) {
          const err = await res.json().catch(() => ({}));
          console.error('Save error:', err);
          showSubmitPopup('Gagal mengirim data. Cek input dan coba lagi.', 'danger');
          return;
        }

        const data = await res.json();
        showSubmitPopup(data.message || 'Data dikirim. Menunggu verifikasi admin.', 'success');

      } catch (err) {
        console.error('Fetch error:', err);
        showSubmitPopup('Terjadi error koneksi. Coba refresh halaman.', 'danger');
      }
    }

    /* ========================
       Add Marker to Map
       ======================== */
    function addMarker(name, lat, lng, address, type, segmen, extra = {}) {
      var icon = (type === 'Indibiz') ? blueIcon : redIcon;
      var typeBadgeClass = (type === 'Indibiz') ? 'popup-type-customer' : 'popup-type-non';

      // Build optional extra rows
      var extraRows = '';
      if (extra.owner_name) {
        extraRows += `<div class="popup-row"><i class="fa-solid fa-user"></i><div><span class="popup-label">Pemilik</span><span class="popup-value">${extra.owner_name}</span></div></div>`;
      }
      if (extra.phone) {
        extraRows += `<div class="popup-row"><i class="fa-solid fa-phone"></i><div><span class="popup-label">Telepon</span><span class="popup-value">${extra.phone}</span></div></div>`;
      }
      if (extra.omset) {
        extraRows += `<div class="popup-row"><i class="fa-solid fa-chart-line"></i><div><span class="popup-label">Omset/Bulan</span><span class="popup-value">${omsetLabel(extra.omset)}</span></div></div>`;
      }
      if (extra.paket_langganan && type === 'Indibiz') {
        extraRows += `<div class="popup-row"><i class="fa-solid fa-box"></i><div><span class="popup-label">Paket</span><span class="popup-value">${extra.paket_langganan}</span></div></div>`;
      }

      var popupHtml = `
        <div class="popup-header">${name}</div>
        <div class="popup-body">
          <div class="popup-row">
            <i class="fa-solid fa-location-dot"></i>
            <div><span class="popup-label">Alamat</span><span class="popup-value">${address}</span></div>
          </div>
          <div class="popup-row">
            <i class="fa-solid fa-tag"></i>
            <div><span class="popup-label">Tipe</span><span class="popup-type-badge ${typeBadgeClass}">${type}</span></div>
          </div>
          <div class="popup-row">
            <i class="fa-solid fa-layer-group"></i>
            <div><span class="popup-label">Segmen</span><span class="popup-value">${segmen}</span></div>
          </div>
          ${extraRows}
        </div>`;

      L.marker([lat, lng], { icon: icon, title: name })
        .bindPopup(popupHtml, { maxWidth: 270 })
        .addTo(markerGroup);
    }

    /* ========================
       Load Approved Markers
       ======================== */
    async function loadMarkers() {
      const res  = await fetch("{{ route('locations.approved') }}", {
        headers: { 'Accept': 'application/json' }
      });
      const rows = await res.json();

      // Keep localStorage in sync for Goals Plan / download
      const markersForLocal = rows.map(r => ({
        name:      r.name,
        latitude:  r.latitude,
        longitude: r.longitude,
        address:   r.address,
        type:      mapDbTypeToUi(r.type),
        segmen:    mapDbSegmentToUi(r.type, r.segment),
      }));
      localStorage.setItem('markers', JSON.stringify(markersForLocal));

      markerGroup.clearLayers();
      rows.forEach(r => {
        addMarker(
          r.name,
          r.latitude,
          r.longitude,
          r.address,
          mapDbTypeToUi(r.type),
          mapDbSegmentToUi(r.type, r.segment),
          {
            owner_name:      r.owner_name      ?? null,
            phone:           r.phone           ?? null,
            business_detail: r.business_detail ?? null,
            omset:           r.omset           ?? null,
            paket_langganan: r.paket_langganan ?? null,
          }
        );
      });
    }

    loadMarkers();

    /* ========================
       Leaflet Search Control
       ======================== */
    L.control.search({
      layer: markerGroup,
      initial: false,
      propertyName: 'title',
      marker: false,
      moveToLocation: function (latlng, title, map) {
        map.setView(latlng, 15);
        var m = markerGroup.getLayers().find(m => m.options.title === title);
        if (m) m.openPopup();
      }
    }).addTo(map);

    /* ========================
       Navigation
       ======================== */
    function redirectToMenu() {
      window.location.href = '{{ url("/menu") }}';
    }

    /* ========================
       Goals Plan Panel
       ======================== */
    document.getElementById('goals-plan-button').addEventListener('click', function () {
      document.getElementById('dataForm').style.display    = 'none';
      document.getElementById('goals-plan').style.display  = 'block';
      document.getElementById('goals-plan-button').style.display = 'none';
      loadGoalsPlan();
    });

    document.getElementById('back-to-form-button').addEventListener('click', function () {
      document.getElementById('dataForm').style.display    = 'block';
      document.getElementById('goals-plan').style.display  = 'none';
      document.getElementById('goals-plan-button').style.display = 'block';
    });

    function loadGoalsPlan() {
      var markers = JSON.parse(localStorage.getItem('markers')) || [];
      var nonCustomerMarkers = markers.filter(m => m.type === 'Non-Customer');
      var container = document.getElementById('goals-plan-container');

      container.innerHTML = '';
      nonCustomerMarkers.forEach(function (markerData, index) {
        var item = document.createElement('div');
        item.className   = 'goals-plan-item';
        item.dataset.index = index;
        item.innerHTML = `
          <span class="marker-icon"><i class="fas fa-map-marker-alt"></i></span>
          <div class="info">
            <div><strong>Nama</strong> ${markerData.name}</div>
            <div><strong>Koordinat</strong> ${markerData.latitude}, ${markerData.longitude}</div>
            <div><strong>Alamat</strong> ${markerData.address}</div>
          </div>
          <div class="actions">
            <button class="btn-check"><i class="fas fa-check"></i></button>
            <button class="btn-info"><i class="fas fa-info-circle"></i></button>
          </div>`;
        container.appendChild(item);

        item.querySelector('.marker-icon').addEventListener('click', function () {
          var latlng = [markerData.latitude, markerData.longitude];
          map.setView(latlng, 15);
          var m = markerGroup.getLayers().find(mk => mk.getLatLng().equals(latlng));
          if (m) m.openPopup();
        });
      });

      container.querySelectorAll('.btn-check').forEach(btn => {
        btn.addEventListener('click', () => btn.classList.toggle('active'));
      });
    }

    /* ========================
       CSV Upload
       ======================== */
    document.getElementById('upload-csv').addEventListener('change', async function (event) {
      const file = event.target.files[0];
      if (!file) return;

      const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
      const formData = new FormData();
      formData.append('file', file);

      try {
        const res  = await fetch("{{ route('locations.import') }}", {
          method: 'POST',
          headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
          body: formData
        });
        const data = await res.json().catch(() => ({}));

        if (!res.ok) {
          showSubmitPopup(data.message || 'Import gagal. Cek format CSV.', 'danger');
          return;
        }

        const inserted = data.inserted ?? 0;
        const failed   = data.failed   ?? 0;
        if (failed > 0) {
          showSubmitPopup(`Import selesai: ${inserted} baris masuk (pending), ${failed} baris gagal.`, 'warning');
          console.warn('Import row errors:', data.errors);
        } else {
          showSubmitPopup(`Import berhasil: ${inserted} baris masuk (pending). Menunggu verifikasi admin.`, 'success');
        }

        await loadMarkers();
      } catch (err) {
        console.error('Import fetch error:', err);
        showSubmitPopup('Terjadi error koneksi saat upload CSV. Coba lagi.', 'danger');
      } finally {
        event.target.value = '';
      }
    });

    /* ========================
       XLSX Download
       ======================== */
    document.getElementById('download-xlsx').addEventListener('click', async function () {
      var markers = JSON.parse(localStorage.getItem('markers')) || [];
      if (markers.length === 0) {
        showSubmitPopup('Tidak ada data untuk diunduh.', 'warning');
        return;
      }

      const workbook  = new ExcelJS.Workbook();
      const worksheet = workbook.addWorksheet('Markers');
      worksheet.columns = [
        { header: 'Nama',      key: 'name',      width: 20 },
        { header: 'Latitude',  key: 'latitude',  width: 15 },
        { header: 'Longitude', key: 'longitude', width: 15 },
        { header: 'Alamat',    key: 'address',   width: 30 },
        { header: 'Tipe',      key: 'type',      width: 15 },
        { header: 'Segmen',    key: 'segmen',    width: 20 },
      ];
      markers.forEach(m => worksheet.addRow(m));

      worksheet.getRow(1).font = { bold: true, color: { argb: 'FFFFFF' } };
      worksheet.getRow(1).fill = { type: 'pattern', pattern: 'solid', fgColor: { argb: 'C02016' } };
      worksheet.eachRow({ includeEmpty: true }, function (row) {
        row.eachCell({ includeEmpty: true }, function (cell) {
          cell.border = {
            top: { style: 'thin', color: { argb: '000000' } },
            left: { style: 'thin', color: { argb: '000000' } },
            bottom: { style: 'thin', color: { argb: '000000' } },
            right: { style: 'thin', color: { argb: '000000' } },
          };
        });
      });

      const buffer = await workbook.xlsx.writeBuffer();
      const blob   = new Blob([buffer], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
      const url    = window.URL.createObjectURL(blob);
      const a      = document.createElement('a');
      a.href = url;
      a.download = 'Informasi_pelanggan.xlsx';
      a.click();
      window.URL.revokeObjectURL(url);
    });

    function clearMarkers() {
      markerGroup.clearLayers();
      localStorage.removeItem('markers');
    }
  </script>
</body>
</html>
