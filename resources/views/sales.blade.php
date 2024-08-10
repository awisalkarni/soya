<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Form</title>
    @livewireStyles
    <style>
        /* Ensure that the table is responsive */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 8px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f4f4f4;
        }

        button {
            padding: 5px;
            border: none;
            background-color: #3490dc;
            color: white;
            border-radius: 4px;
        }

        input[type="text"] {
            width: 40px;
            padding: 5px;
            text-align: center;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
    </style>
</head>
<body class="bg-gray-100">

<div class="container mx-auto p-4">
    <h1 class="text-xl font-bold mb-4">Sales Form</h1>

    <!-- SalesForm Livewire Component -->
    <livewire:sales.sales-form :company_id=$companyId />
</div>

@livewireScripts
</body>
</html>
