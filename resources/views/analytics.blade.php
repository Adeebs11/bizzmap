<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analytic Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/styleanalytics.css') }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.2.1/exceljs.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/xlsx/dist/xlsx.full.min.js"></script>


</head>
<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between mb-4">
            <a href="javascript:history.back()" class="btn btn-light">
                <i class="fas fa-arrow-left"></i> Back
            </a>
            <h1 class="text-center mb-0 flex-grow-1">Analytic</h1>
            <a href="{{ url('/menu') }}" class="btn btn-light">
                <i class="fas fa-home"></i> Home
            </a>
        </div>

        <!-- Switch between Customer and Non-Customer -->
        <div class="d-flex justify-content-center mb-4">
            <button id="btn-customer" class="btn btn-primary me-2">Customer Indibiz</button>
            <button id="btn-non-customer" class="btn btn-secondary">Non-Customer</button>
        </div>

        <div id="customer-segment" class="row">
            <!-- Indibiz Segments -->
            <div class="col-md-6 mb-4">
                <div class="summary-box">
                    <i class="fa-solid fa-building summary-icon"></i>
                    <h2>Indibiz Ruko</h2>
                    <p>Berdasarkan data demografi, jumlah pengguna pada segmen Indibiz Ruko adalah sebanyak 
                        <span id="indibiz-ruko-count" class="highlighted-count">[....]</span>
                    </p>
                    <p id="indibiz-ruko-message"></p>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="summary-box">
                    <i class="fa-solid fa-school summary-icon"></i>
                    <h2>Indibiz Sekolah</h2>
                    <p>Berdasarkan data demografi, jumlah pengguna pada segmen Indibiz Sekolah adalah sebanyak 
                        <span id="indibiz-sekolah-count" class="highlighted-count">[....]</span>
                    </p>
                    <p id="indibiz-sekolah-message"></p>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="summary-box">
                    <i class="fa-solid fa-hotel summary-icon"></i>
                    <h2>Indibiz Hotel</h2>
                    <p>Berdasarkan data demografi, jumlah pengguna pada segmen Indibiz Hotel adalah sebanyak 
                        <span id="indibiz-hotel-count" class="highlighted-count">[....]</span>
                    </p>
                    <p id="indibiz-hotel-message"></p>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="summary-box">
                    <i class="fa-solid fa-money-bill summary-icon"></i>
                    <h2>Indibiz MultiFinance</h2>
                    <p>Berdasarkan data demografi, jumlah pengguna pada segmen Indibiz MultiFinance adalah sebanyak 
                        <span id="indibiz-multifinance-count" class="highlighted-count">[....]</span>
                    </p>
                    <p id="indibiz-multifinance-message"></p>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="summary-box">
                    <i class="fa-solid fa-house-medical summary-icon"></i>
                    <h2>Indibiz Health</h2>
                    <p>Berdasarkan data demografi, jumlah pengguna pada segmen Indibiz Health adalah sebanyak 
                        <span id="indibiz-health-count" class="highlighted-count">[....]</span>
                    </p>
                    <p id="indibiz-health-message"></p>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="summary-box">
                    <i class="fa-solid fa-truck summary-icon"></i>
                    <h2>Indibiz Ekspedisi</h2>
                    <p>Berdasarkan data demografi, jumlah pengguna pada segmen Indibiz Ekspedisi adalah sebanyak 
                        <span id="indibiz-ekspedisi-count" class="highlighted-count">[....]</span>
                    </p>
                    <p id="indibiz-ekspedisi-message"></p>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="summary-box">
                    <i class="fa-solid fa-bolt summary-icon"></i>
                    <h2>Indibiz Energy</h2>
                    <p>Berdasarkan data demografi, jumlah pengguna pada segmen Indibiz Energy adalah sebanyak 
                        <span id="indibiz-energy-count" class="highlighted-count">[....]</span>
                    </p>
                    <p id="indibiz-energy-message"></p>
                </div>
            </div>
        </div>

        <div id="non-customer-segment" class="row" style="display: none;">
            <!-- Non-Customer Segments -->
            <div class="col-md-6 mb-4">
                <div class="summary-box">
                    <i class="fa-solid fa-building summary-icon"></i>
                    <h2>Ruko</h2>
                    <p>Berdasarkan data demografi, jumlah pengguna pada segmen Ruko adalah sebanyak 
                        <span id="ruko-count" class="highlighted-count">[....]</span>
                    </p>
                    <p id="ruko-message"></p>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="summary-box">
                    <i class="fa-solid fa-school summary-icon"></i>
                    <h2>Sekolah</h2>
                    <p>Berdasarkan data demografi, jumlah pengguna pada segmen Sekolah adalah sebanyak 
                        <span id="sekolah-count" class="highlighted-count">[....]</span>
                    </p>
                    <p id="sekolah-message"></p>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="summary-box">
                    <i class="fa-solid fa-hotel summary-icon"></i>
                    <h2>Hotel</h2>
                    <p>Berdasarkan data demografi, jumlah pengguna pada segmen Hotel adalah sebanyak 
                        <span id="hotel-count" class="highlighted-count">[....]</span>
                    </p>
                    <p id="hotel-message"></p>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="summary-box">
                    <i class="fa-solid fa-money-bill summary-icon"></i>
                    <h2>MultiFinance</h2>
                    <p>Berdasarkan data demografi, jumlah pengguna pada segmen MultiFinance adalah sebanyak 
                        <span id="multifinance-count" class="highlighted-count">[....]</span>
                    </p>
                    <p id="multifinance-message"></p>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="summary-box">
                    <i class="fa-solid fa-house-medical summary-icon"></i>
                    <h2>Health</h2>
                    <p>Berdasarkan data demografi, jumlah pengguna pada segmen Health adalah sebanyak 
                        <span id="health-count" class="highlighted-count">[....]</span>
                    </p>
                    <p id="health-message"></p>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="summary-box">
                    <i class="fa-solid fa-truck summary-icon"></i>
                    <h2>Ekspedisi</h2>
                    <p>Berdasarkan data demografi, jumlah pengguna pada segmen Ekspedisi adalah sebanyak 
                        <span id="ekspedisi-count" class="highlighted-count">[....]</span>
                    </p>
                    <p id="ekspedisi-message"></p>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="summary-box">
                    <i class="fa-solid fa-bolt summary-icon"></i>
                    <h2>Energy</h2>
                    <p>Berdasarkan data demografi, jumlah pengguna pada segmen Energy adalah sebanyak 
                        <span id="energy-count" class="highlighted-count">[....]</span>
                    </p>
                    <p id="energy-message"></p>
                </div>
            </div>
        </div>
    </div>

    <script>

        // Function to download the data for a specific segment as XLSX
        async function downloadSegmentData(type, segmen) {
    console.log("Downloading data for:", type, segmen); // Debugging log

    var markers = JSON.parse(localStorage.getItem('markers')) || [];
    var filteredMarkers = markers.filter(marker => marker.type === type && marker.segmen === segmen);

    if (filteredMarkers.length === 0) {
        alert('Tidak ada data marker untuk diunduh.');
        return;
    }

    try {
        // Create a new workbook and add a worksheet
        const workbook = new ExcelJS.Workbook();
        const worksheet = workbook.addWorksheet(`${segmen} Markers`);

        // Define header styles
        const headerStyle = {
            font: { bold: true, color: { argb: 'FFFFFF' } },
            fill: { type: 'pattern', pattern: 'solid', fgColor: { argb: '00FF00' } }, // Green fill color
            border: {
                top: { style: 'thin' },
                left: { style: 'thin' },
                bottom: { style: 'thin' },
                right: { style: 'thin' }
            },
            alignment: { horizontal: 'center' }
        };

        // Define cell styles
        const cellStyle = {
            border: {
                top: { style: 'thin' },
                left: { style: 'thin' },
                bottom: { style: 'thin' },
                right: { style: 'thin' }
            },
            font: { size: 10 }
        };

        // Set columns
        worksheet.columns = Object.keys(filteredMarkers[0]).map(key => ({ header: key, key: key }));

        // Add rows
        filteredMarkers.forEach(marker => {
            worksheet.addRow(marker);
        });

        // Apply header styles
        worksheet.getRow(1).eachCell({ includeEmpty: true }, (cell) => {
            cell.style = headerStyle;
        });

        // Apply cell styles
        worksheet.eachRow({ includeEmpty: true }, (row) => {
            row.eachCell({ includeEmpty: true }, (cell) => {
                cell.style = cellStyle;
            });
        });

        // Adjust column widths
        worksheet.columns.forEach(column => {
            let maxLength = 0;
            column.eachCell({ includeEmpty: true }, cell => {
                const cellLength = cell.value ? cell.value.toString().length : 0;
                if (cellLength > maxLength) {
                    maxLength = cellLength;
                }
            });
            column.width = maxLength < 10 ? 10 : maxLength + 2;
        });

        // Write file
        workbook.xlsx.writeBuffer().then(buffer => {
            const blob = new Blob([buffer], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `${segmen}_markers.xlsx`;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
        }).catch(error => {
            console.error("Error writing buffer:", error); // Debugging log
        });

    } catch (error) {
        console.error("Error in downloadSegmentData:", error); // Debugging log
    }
}


// Add click event listeners to the count elements
document.getElementById('indibiz-ruko-count').addEventListener('click', function() {
    downloadSegmentData('Indibiz', 'Indibiz Ruko');
});

document.getElementById('indibiz-sekolah-count').addEventListener('click', function() {
    downloadSegmentData('Indibiz', 'Indibiz Sekolah');
});

document.getElementById('indibiz-hotel-count').addEventListener('click', function() {
    downloadSegmentData('Indibiz', 'Indibiz Hotel');
});

document.getElementById('indibiz-multifinance-count').addEventListener('click', function() {
    downloadSegmentData('Indibiz', 'Indibiz MultiFinance');
});

document.getElementById('indibiz-health-count').addEventListener('click', function() {
    downloadSegmentData('Indibiz', 'Indibiz Health');
});

document.getElementById('indibiz-ekspedisi-count').addEventListener('click', function() {
    downloadSegmentData('Indibiz', 'Indibiz Ekspedisi');
});

document.getElementById('indibiz-energy-count').addEventListener('click', function() {
    downloadSegmentData('Indibiz', 'Indibiz Energy');
});

// Non-Customer event listeners
document.getElementById('ruko-count').addEventListener('click', function() {
    downloadSegmentData('Non-Customer', 'Ruko');
});

document.getElementById('sekolah-count').addEventListener('click', function() {
    downloadSegmentData('Non-Customer', 'Sekolah');
});

document.getElementById('hotel-count').addEventListener('click', function() {
    downloadSegmentData('Non-Customer', 'Hotel');
});

document.getElementById('multifinance-count').addEventListener('click', function() {
    downloadSegmentData('Non-Customer', 'MultiFinance');
});

document.getElementById('health-count').addEventListener('click', function() {
    downloadSegmentData('Non-Customer', 'Health');
});

document.getElementById('ekspedisi-count').addEventListener('click', function() {
    downloadSegmentData('Non-Customer', 'Ekspedisi');
});

document.getElementById('energy-count').addEventListener('click', function() {
    downloadSegmentData('Non-Customer', 'Energy');
});

       function showSection(sectionToShow, sectionToHide, activeButton, inactiveButton) {
    // Sembunyikan section yang tidak aktif
    document.getElementById(sectionToHide).style.display = 'none';
    
    // Tampilkan section yang aktif
    const section = document.getElementById(sectionToShow);
    section.style.display = 'flex';
    section.style.flexWrap = 'wrap';

    // Update tombol
    document.getElementById(activeButton).classList.add('btn-primary');
    document.getElementById(activeButton).classList.remove('btn-secondary');
    document.getElementById(inactiveButton).classList.add('btn-secondary');
    document.getElementById(inactiveButton).classList.remove('btn-primary');
}


        document.getElementById('btn-customer').addEventListener('click', function() {
            showSection('customer-segment', 'non-customer-segment', 'btn-customer', 'btn-non-customer');
        });

        document.getElementById('btn-non-customer').addEventListener('click', function() {
            showSection('non-customer-segment', 'customer-segment', 'btn-non-customer', 'btn-customer');
        });

        document.addEventListener('DOMContentLoaded', function () {
            function getDataFromStorage() {
                return JSON.parse(localStorage.getItem('markers')) || [];
            }

            function countDataBySegmen(type, segmen) {
                let markers = getDataFromStorage();
                return markers.filter(marker => marker.type === type && marker.segmen === segmen).length;
            }

            function updateSegmentInfo(segmentId, type, segmen) {
                const count = countDataBySegmen(type, segmen);
                const countElement = document.getElementById(`${segmentId}-count`);
                const messageElement = document.getElementById(`${segmentId}-message`);

                countElement.innerText = count;

                if (count >= 15) {
                    messageElement.innerText = `Segmen ini sangat diminati oleh pelanggan, mencerminkan kebutuhan yang tinggi di kalangan bisnis dan masyarakat. 
                    Segmen ini memiliki potensi besar untuk terus berkembang dan menjadi andalan dalam strategi bisnis Indibiz. Investasi tambahan dan inovasi di segmen ini dapat mendorong pertumbuhan yang lebih signifikan`;
                    messageElement.style.color = "green";
                    countElement.style.textDecoration = "underline";
                } else if (count < 15 && count > 5) {
                    messageElement.innerText = `Segmen ini menunjukkan minat yang stabil di kalangan pengguna, dengan potensi untuk berkembang lebih lanjut. Ini adalah segmen yang layak untuk dipertahankan dan dioptimalkan dengan strategi yang tepat, demi menarik lebih banyak pelanggan dan meningkatkan penetrasi pasar.`;
                    messageElement.style.color = "blue";
                    countElement.style.textDecoration = "underline";
                } else if (count < 5 && count > 0) {
                    messageElement.innerText = `Segmen ini saat ini kurang diminati oleh pengguna. Hal ini bisa menjadi indikasi bahwa ada tantangan di pasar atau kebutuhan yang belum terpenuhi. Mungkin perlu ada pendekatan baru atau strategi yang lebih inovatif untuk menarik minat pelanggan dan meningkatkan keterlibatan di segmen ini.`;
                    messageElement.style.color = "orange";
                    countElement.style.textDecoration = "underline";
                } else if (count === 0) {
                    messageElement.innerText = `Segmen ini belum berhasil menarik pengguna. Ini mungkin mengindikasikan bahwa penawaran saat ini tidak relevan atau ada hambatan lain yang menghalangi penetrasi di pasar ini. Segmen ini membutuhkan pendekatan yang benar-benar baru untuk bisa menarik perhatian dan menghasilkan minat dari calon pelanggan.`;
                    messageElement.style.color = "red";
                    countElement.style.textDecoration = "underline";
                } else {
                    messageElement.innerText = ``;
                    countElement.style.textDecoration = "none";
                }
            }

            // Update Indibiz segments
            updateSegmentInfo('indibiz-ruko', 'Indibiz', 'Indibiz Ruko');
            updateSegmentInfo('indibiz-sekolah', 'Indibiz', 'Indibiz Sekolah');
            updateSegmentInfo('indibiz-hotel', 'Indibiz', 'Indibiz Hotel');
            updateSegmentInfo('indibiz-multifinance', 'Indibiz', 'Indibiz MultiFinance');
            updateSegmentInfo('indibiz-health', 'Indibiz', 'Indibiz Health');
            updateSegmentInfo('indibiz-ekspedisi', 'Indibiz', 'Indibiz Ekspedisi');
            updateSegmentInfo('indibiz-energy', 'Indibiz', 'Indibiz Energy');

            // Update Non-Customer segments
            updateSegmentInfo('ruko', 'Non-Customer', 'Ruko');
            updateSegmentInfo('sekolah', 'Non-Customer', 'Sekolah');
            updateSegmentInfo('hotel', 'Non-Customer', 'Hotel');
            updateSegmentInfo('multifinance', 'Non-Customer', 'MultiFinance');
            updateSegmentInfo('health', 'Non-Customer', 'Health');
            updateSegmentInfo('ekspedisi', 'Non-Customer', 'Ekspedisi');
            updateSegmentInfo('energy', 'Non-Customer', 'Energy');
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
