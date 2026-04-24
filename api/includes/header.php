<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Griya Savitri - Salon & Spa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Montserrat:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Montserrat', sans-serif; }
        h1, h2, h3 { font-family: 'Playfair Display', serif; }
        .bg-beige { background-color: #F5F5DC; }
        .text-rosegold { color: #B76E79; }
        .bg-rosegold { background-color: #B76E79; }
        .border-rosegold { border-color: #B76E79; }
    </style>
</head>
<body class="bg-[#FAF9F6] text-[#333333]">
    <!-- Navbar -->
    <nav class="fixed w-full z-50 bg-[#FAF9F6]/80 backdrop-blur-md border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 sm:h-20 items-center">
                <div class="flex-shrink-0">
                    <a href="index.php" class="text-xl sm:text-2xl font-bold tracking-tighter text-rosegold">GRIYA <span class="text-[#333333]">SAVITRI</span></a>
                </div>
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-8">
                        <a href="index.php" class="hover:text-rosegold transition-colors duration-300">Home</a>
                        <a href="services.php" class="hover:text-rosegold transition-colors duration-300">Services</a>
                        <a href="index.php#about" class="hover:text-rosegold transition-colors duration-300">About</a>
                        <a href="booking.php" class="bg-rosegold text-white px-6 py-2 rounded-full hover:bg-opacity-90 transition-all duration-300 shadow-lg shadow-rosegold/20">Book Now</a>
                    </div>
                </div>
                <div class="md:hidden">
                    <button id="mobile-menu-button" class="text-[#333333] hover:text-rosegold p-2">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden bg-white border-b border-gray-100 px-4 py-4 space-y-2">
            <a href="index.php" class="block py-2 hover:text-rosegold">Home</a>
            <a href="services.php" class="block py-2 hover:text-rosegold">Services</a>
            <a href="index.php#about" class="block py-2 hover:text-rosegold">About</a>
            <a href="booking.php" class="block py-2 text-rosegold font-semibold">Book Now</a>
        </div>
    </nav>

    <script>
        const btn = document.getElementById('mobile-menu-button');
        const menu = document.getElementById('mobile-menu');
        btn.addEventListener('click', () => {
            menu.classList.toggle('hidden');
        });
    </script>
