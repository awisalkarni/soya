<?php

namespace App\Livewire;

use App\Models\Company;
use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dashboard extends Component
{
    public $todaySales;
    public $weekSales;
    public $monthSales;
    public $companies;
    public $selectedCompany;

    public function mount()
    {
        $this->loadCompanies();
        $this->selectedCompany = $this->companies->first()->id ?? null;
        $this->calculateSales();
    }

    public function loadCompanies()
    {
        // Get companies attached to the authenticated user
        $this->companies = Auth::user()->companies;
    }

    public function updatedSelectedCompany($value)
    {
        $this->selectedCompany = $value;
        $this->calculateSales();
    }

    public function calculateSales()
    {
        if ($this->selectedCompany) {
            $this->todaySales = Sale::where('company_id', $this->selectedCompany)
                ->whereDate('created_at', Carbon::today())
                ->sum('total');

            $this->weekSales = Sale::where('company_id', $this->selectedCompany)
                ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                ->sum('total');

            $this->monthSales = Sale::where('company_id', $this->selectedCompany)
                ->whereMonth('created_at', Carbon::now()->month)
                ->whereYear('created_at', Carbon::now()->year)
                ->sum('total');
        } else {
            $this->todaySales = $this->weekSales = $this->monthSales = 0;
        }
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
