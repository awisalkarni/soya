<!-- resources/views/landing.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales System Landing Page</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">

    <!-- Header Section -->
    <header class="bg-blue-600 text-white p-6">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-3xl font-bold">Sales System</h1>
            <nav>
                <a href="#features" class="text-lg mx-2 hover:underline">Features</a>
                <a href="#contact" class="text-lg mx-2 hover:underline">Contact</a>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="bg-blue-500 text-white p-10">
        <div class="container mx-auto text-center">
            <h2 class="text-4xl font-bold mb-4">Efficient Sales Management</h2>
            <p class="text-lg mb-6">Manage your sales seamlessly with our powerful and easy-to-use sales system.</p>
            <a href="{{ route('sales.form') }}"
                class="bg-white text-blue-500 font-bold py-2 px-4 rounded hover:bg-gray-200">Get Started</a>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="p-10 bg-gray-200">
        <div class="container mx-auto text-center">
            <h3 class="text-3xl font-bold mb-8">Features</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="p-6 bg-white shadow-lg rounded">
                    <h4 class="text-2xl font-bold mb-4">Product Management</h4>
                    <p>Manage your products efficiently with our streamlined product management system.</p>
                </div>
                <div class="p-6 bg-white shadow-lg rounded">
                    <h4 class="text-2xl font-bold mb-4">Sales Tracking</h4>
                    <p>Track your sales in real-time and generate detailed reports to help you make informed decisions.
                    </p>
                </div>
                <div class="p-6 bg-white shadow-lg rounded">
                    <h4 class="text-2xl font-bold mb-4">Client Management</h4>
                    <p>Maintain a detailed record of your clients and manage your relationships effectively.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="p-10 bg-white">
        <div class="container mx-auto text-center">
            <h3 class="text-3xl font-bold mb-8">Get in Touch</h3>
            <p class="mb-4">Have any questions? Feel free to reach out to us.</p>
            <a href="mailto:support@example.com"
                class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-700">Contact Us</a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white p-6">
        <div class="container mx-auto text-center">
            <p>&copy; {{ date('Y') }} Sales System. All rights reserved.</p>
        </div>
    </footer>

</body>

</html>
