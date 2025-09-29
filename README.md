# 🧠 Prediksi Hipertensi Berbasis GIS & Machine Learning

## 📌 Deskripsi Singkat  
Proyek ini adalah sistem **Prediksi Hipertensi Terintegrasi** berbasis **Laravel + Machine Learning (Python)** yang dirancang untuk membantu **analisis kesehatan masyarakat secara spasial dan temporal**.  
Sistem memanfaatkan **data geospasial** (GeoJSON) dan **dataset tahunan** yang dikonversi menjadi per bulan untuk memprediksi tingkat risiko hipertensi berdasarkan wilayah (kecamatan) dan waktu.  

Aplikasi ini menyajikan hasil prediksi secara **interaktif dalam bentuk peta** menggunakan **Leaflet.js**, dengan fitur-fitur sebagai berikut:
- 📍 Visualisasi titik lokasi berdasarkan prioritas risiko  
- 🗺️ Filter berdasarkan **tahun, bulan, dan kategori rute distribusi**  
- 🛣️ Kategori rute yang menunjukkan jalur atau prioritas wilayah  
- 📊 Dashboard analisis tren hipertensi per wilayah

---

## ⚙️ Fitur Utama

- ✅ **📊 Prediksi Risiko Hipertensi:** Menggunakan algoritma ML berbasis *Random Forest* untuk memprediksi tingkat risiko per kecamatan.
- ✅ **🗺️ Peta Interaktif:** Menampilkan hasil prediksi dalam bentuk peta spasial lengkap dengan filter tahun, bulan, dan rute.
- ✅ **📁 Konversi Dataset Otomatis:** Mengubah dataset tahunan menjadi data per-bulan secara otomatis dengan satu perintah artisan.
- ✅ **🧪 Pipeline ML Otomatis:** Sistem dapat melakukan training dan prediksi ulang model ML langsung dari command line Laravel.
- ✅ **📦 Integrasi Python + Laravel:** Machine Learning dijalankan di lingkungan virtual Python (*virtualenv*) dan terintegrasi langsung ke dalam workflow Laravel.

---

## 🛠️ Instalasi & Persiapan

### 1. Install PHP Spreadsheet (untuk konversi Excel)
```bash
composer require phpoffice/phpspreadsheet
apt-get update && apt-get install -y python3-venv
python3 -m venv /var/www/html/venv
source /var/www/html/venv/bin/activate
pip install pandas openpyxl scikit-learn joblib geopandas shapely fiona pyproj

php artisan ml:convert-excel

php artisan ml:predict --input=ml_input/dataset.csv --geo=ml_input/penelitian.geojson

---

## 📊 Alur Sistem

- 📥 Admin mengunggah dataset tahunan hipertensi (Excel).

- 🔄 Sistem mengonversi dataset menjadi format bulanan (ml:convert-excel).

- 🧠 Model ML dijalankan untuk memprediksi risiko (ml:predict).

- 🗺️ Hasil prediksi divisualisasikan dalam peta interaktif Filament Admin Panel.

- 📊 Data dapat difilter berdasarkan tahun, bulan, dan kategori rute distribusi.

---