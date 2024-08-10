<?php

namespace App\Livewire\Modals;

use App\Models\Sale;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class SalesDetails extends ModalComponent
{
    public $sale;
    public $saleId;

    public function mount($saleId)
    {
        $this->saleId = $saleId;
        $this->loadSaleDetails();
    }

    public function loadSaleDetails()
    {
        $this->sale = Sale::with('saleItems.product', 'client')
                          ->findOrFail($this->saleId);
    }
    public function render()
    {
        return view('livewire.modals.sales-details');
    }
}
