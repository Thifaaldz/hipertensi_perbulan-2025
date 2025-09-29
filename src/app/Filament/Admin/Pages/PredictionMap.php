<?php

namespace App\Filament\Admin\Pages;

use Filament\Pages\Page;
use App\Models\Prediction;
use Illuminate\Http\Request;

class PredictionMap extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-map';
    protected static string $view = 'filament.admin.pages.prediction-map';
    protected static ?string $navigationLabel = 'Peta Prediksi';
    protected static ?string $title = 'Peta Prediksi Hipertensi';

    public $tahun;
    public $focus_month;
    public $predicted_route;

    public function mount(Request $request)
    {
        $this->tahun = $request->get('tahun');
        $this->focus_month = $request->get('focus_month');
        $this->predicted_route = $request->get('predicted_route');
    }

    public function getPredictions()
    {
        $query = Prediction::query()
            ->whereNotNull('lat')
            ->whereNotNull('lon');

        if ($this->tahun) {
            $query->where('tahun', $this->tahun);
        }

        if ($this->focus_month) {
            $query->where('focus_month', $this->focus_month);
        }

        if ($this->predicted_route) {
            $query->where('predicted_route', $this->predicted_route);
        }

        return $query->get([
            'kecamatan',
            'wilayah',
            'tahun',
            'focus_month',
            'persentase',
            'prioritas',
            'predicted_route',
            'focus_date',
            'lat',
            'lon'
        ]);
    }

    public function getTahunOptions()
    {
        return Prediction::select('tahun')
            ->distinct()
            ->orderBy('tahun', 'asc')
            ->pluck('tahun');
    }

    public function getBulanOptions()
    {
        return Prediction::select('focus_month')
            ->distinct()
            ->orderBy('focus_month', 'asc')
            ->pluck('focus_month');
    }

    public function getRouteOptions()
    {
        return Prediction::select('predicted_route')
            ->distinct()
            ->orderBy('predicted_route', 'asc')
            ->pluck('predicted_route');
    }
}
