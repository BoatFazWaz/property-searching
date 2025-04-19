<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Luxury Properties - Elegant Living in Thailand</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Raleway:wght@300;400;500;600&display=swap" rel="stylesheet">

        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased">
        <div id="app" class="min-h-screen bg-gray-100 py-12 px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto">
                <h1 class="text-4xl font-serif font-bold text-center mb-12 text-indigo-900">Luxury Properties</h1>
                
                <!-- Sample Property Card with line-clamp -->
                <div class="bg-white rounded-lg shadow-luxury overflow-hidden max-w-md mx-auto">
                    <div class="relative h-64">
                        <img class="w-full h-full object-cover" src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" alt="Luxury villa">
                        <div class="absolute top-0 right-0 bg-gold text-white px-3 py-1 m-3 rounded">
                            <i class="fas fa-star mr-1"></i> Featured
                        </div>
                    </div>
                    <div class="p-6">
                        <h2 class="text-2xl font-serif font-semibold text-gray-900 mb-2">Beachfront Villa</h2>
                        <p class="text-gold-dark text-lg mb-2">$2,500,000</p>
                        <div class="flex mb-4">
                            <div class="mr-4"><i class="fas fa-bed text-indigo-800 mr-2"></i> 4 Beds</div>
                            <div class="mr-4"><i class="fas fa-bath text-indigo-800 mr-2"></i> 5 Baths</div>
                            <div><i class="fas fa-ruler-combined text-indigo-800 mr-2"></i> 350 m²</div>
                        </div>
                        <p class="text-gray-600 line-clamp-3 mb-4">
                            This stunning beachfront villa offers exceptional luxury living with direct access to the pristine white sand beach. Featuring panoramic ocean views, a private infinity pool, and meticulously designed interiors. The property includes a gourmet kitchen, spacious living areas, a home theater, and a private garden sanctuary. Perfect for those seeking an exclusive tropical retreat in Thailand's most desirable location.
                        </p>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500"><i class="fas fa-map-marker-alt mr-1"></i> Phuket, Thailand</span>
                            <button class="bg-gradient-luxury text-white px-4 py-2 rounded hover:opacity-90 transition-opacity">
                                View Details
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
