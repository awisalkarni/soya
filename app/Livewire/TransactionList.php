<?php

namespace App\Livewire;

use App\Models\Client;
use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TransactionList extends Component
{

    public $startDate;
    public $endDate;
    public $client_id;
    public $company_id;
    public $clients;
    public $companies;
    public $sales;

    public function mount()
    {
        $this->companies = Auth::user()->companies; // Fetch companies associated with the authenticated user
        $this->company_id = $this->companies->first()->id ?? null; // Default to the first company
        $this->clients = Client::where('company_id', $this->company_id)->get();
        $this->filterSales();
    }

    public function updatedCompanyId()
    {
        $this->clients = Client::where('company_id', $this->company_id)->get();
        $this->client_id = null; // Reset client selection when company changes
        $this->filterSales();
    }

    public function updated($propertyName)
    {
        if ($propertyName !== 'company_id') {
            $this->filterSales();
        }
    }

    public function showDetails($saleId)
    {
        $sale = Sale::with('saleItems')->findOrFail($saleId);

        // You can handle showing details here, e.g., open a modal or redirect to a details page
        // Example: emit an event to open a modal
        $this->emit('openSaleDetailsModal', $sale);
    }

    public function filterSales()
    {
        $query = Sale::query();

        if ($this->company_id) {
            $query->where('company_id', $this->company_id);
        }

        if ($this->startDate) {
            $query->whereDate('created_at', '>=', Carbon::parse($this->startDate));
        }

        if ($this->endDate) {
            $query->whereDate('created_at', '<=', Carbon::parse($this->endDate));
        }

        if ($this->client_id) {
            $query->where('client_id', $this->client_id);
        }

        $this->sales = $query->get();
    }

    public function render()
    {
        return view('livewire.transaction-list');
    }
}
