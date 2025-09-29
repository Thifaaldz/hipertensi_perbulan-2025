<x-filament::page>
    <style>
        #map {
            height: 600px;
            width: 100%;
            border-radius: 8px;
        }

        .filter-container {
            margin-bottom: 1rem;
            display: flex;
            gap: 1rem;
        }

        .filter-container form {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .filter-container select, .filter-container button {
            padding: 0.4rem 0.8rem;
            border-radius: 6px;
        }
    </style>

    <div class="filter-container">
        <form method="GET">
            <div>
                <label><b>Tahun:</b></label>
                <select name="tahun">
                    <option value="">Semua</option>
                    @foreach($this->getTahunOptions() as $tahun)
                        <option value="{{ $tahun }}" {{ request('tahun') == $tahun ? 'selected' : '' }}>
                            {{ $tahun }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label><b>Bulan:</b></label>
                <select name="focus_month">
                    <option value="">Semua</option>
                    @foreach($this->getBulanOptions() as $bulan)
                        <option value="{{ $bulan }}" {{ request('focus_month') == $bulan ? 'selected' : '' }}>
                            Bulan {{ $bulan }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label><b>Rute:</b></label>
                <select name="predicted_route">
                    <option value="">Semua</option>
                    @foreach($this->getRouteOptions() as $route)
                        <option value="{{ $route }}" {{ request('predicted_route') == $route ? 'selected' : '' }}>
                            Rute {{ $route }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" style="background: #1d4ed8; color: #fff; border: none;">
                Filter
            </button>
        </form>
    </div>

    <div id="map"></div>

    {{-- Leaflet CSS & JS --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const map = L.map('map').setView([-6.2, 106.8], 10);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            const predictions = @json($this->getPredictions());

            if (predictions.length === 0) {
                alert("⚠️ Tidak ada data prediksi sesuai filter");
                return;
            }

            const markers = [];
            predictions.forEach((item, index) => {
                if (item.lat && item.lon) {
                    const marker = L.circleMarker([item.lat, item.lon], {
                        radius: 7,
                        color: item.prioritas === 'Prioritas' ? 'red' : 'blue',
                        fillOpacity: 0.8
                    })
                    .bindPopup(`
                        <b>${item.kecamatan}</b><br>
                        📍 Wilayah: ${item.wilayah ?? '-'}<br>
                        📅 Tahun: ${item.tahun ?? '-'}<br>
                        📆 Bulan: ${item.focus_month ?? '-'}<br>
                        📊 Persentase: ${parseFloat(item.persentase).toFixed(2)}%<br>
                        🚦 Prioritas: ${item.prioritas ?? '-'}<br>
                        🛣️ Kategori Rute: Rute ${item.predicted_route ?? '-'} ke titik ${index + 1}<br>
                        📌 Fokus: ${item.focus_date ?? '-'}
                    `)
                    .addTo(map);

                    markers.push(marker);
                }
            });

            if (markers.length > 0) {
                const group = new L.featureGroup(markers);
                map.fitBounds(group.getBounds().pad(0.2));
            }
        });
    </script>
</x-filament::page>
