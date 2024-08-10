<div class="bg-white p-6 rounded-lg shadow-lg">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Sales Dashboard</h2>

    <!-- Company Selection -->
    <div class="mb-6">
        <label for="company" class="block text-sm font-medium text-gray-700">Company:</label>
        <select wire:model.live="selectedCompany" id="company" class="block w-full mt-1 p-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
            @foreach($companies as $company)
                <option value="{{ $company->id }}">{{ $company->name }}</option>
            @endforeach
        </select>
    </div>

    <!-- Sales Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="p-6 bg-blue-100 rounded-lg shadow-md">
            <h3 class="text-lg font-semibold text-blue-700">Today's Sales</h3>
            <p class="text-3xl font-bold text-blue-900 mt-2">RM{{ number_format($todaySales, 2) }}</p>
        </div>

        <div class="p-6 bg-green-100 rounded-lg shadow-md">
            <h3 class="text-lg font-semibold text-green-700">This Week's Sales</h3>
            <p class="text-3xl font-bold text-green-900 mt-2">RM{{ number_format($weekSales, 2) }}</p>
        </div>

        <div class="p-6 bg-yellow-100 rounded-lg shadow-md">
            <h3 class="text-lg font-semibold text-yellow-700">This Month's Sales</h3>
            <p class="text-3xl font-bold text-yellow-900 mt-2">RM{{ number_format($monthSales, 2) }}</p>
        </div>
    </div>

    <!-- Button to Sales Form -->
    <div class="text-right">
        <a href="{{ route('sales.form') }}" class="inline-block bg-blue-500 text-white font-bold py-2 px-4 rounded-lg shadow hover:bg-blue-600 transition">
            Go to Sales Form
        </a>
    </div>
</div>
