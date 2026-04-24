require_once '../includes/functions.php';
require_once '../includes/db.php';
include '../includes/header.php';
?>

<!-- Hero Section -->
<section class="relative h-screen flex items-center overflow-hidden">
    <div class="absolute inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1560066984-138dadb4c035?ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80" alt="Salon Interior" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-black/40"></div>
    </div>
    
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-white text-center md:text-left">
        <h3 class="text-white/80 font-semibold tracking-widest uppercase text-xs sm:text-sm mb-4 animate-fade-in">Luxury Experience</h3>
        <h1 class="text-4xl sm:text-7xl font-bold leading-tight mb-6 sm:mb-8">
            <span class="bg-white/95 text-rosegold px-4 py-1 rounded-xl inline-block mb-2">Griya Savitri</span> <br>
            <span class="text-white">Salon & Spa</span>
        </h1>
        <p class="text-base sm:text-xl text-white/90 mb-8 sm:mb-12 max-w-xl leading-relaxed">Sentuhan profesional untuk kecantikan dan relaksasi Anda. Hadir dengan konsep modern dan tim ahli berpengalaman.</p>
        <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-6 justify-center md:justify-start">
            <a href="<?php echo get_wa_link(); ?>" target="_blank" class="bg-white text-rosegold px-8 sm:px-10 py-4 sm:py-5 rounded-full font-bold text-base sm:text-lg hover:bg-gray-100 transition-all shadow-2xl shadow-white/10 text-center">Book Reservation</a>
            <a href="services.php" class="bg-transparent text-white border-2 border-white/30 px-8 sm:px-10 py-4 sm:py-5 rounded-full font-bold text-base sm:text-lg hover:bg-white/10 transition-all text-center">Our Services</a>
        </div>
    </div>
</section>

<!-- About Section -->
<section id="about" class="py-16 sm:py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10 md:gap-16 items-center">
            <div class="relative group">
                <div class="absolute -inset-4 bg-rosegold/5 rounded-2xl transition-all group-hover:bg-rosegold/10"></div>
                <img src="https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Salon Service" class="relative rounded-xl shadow-2xl group-hover:scale-[1.02] transition-transform duration-500">
            </div>
            <div>
                <h3 class="text-rosegold font-semibold tracking-widest uppercase text-xs sm:text-sm mb-4">Mengenai Kami</h3>
                <h2 class="text-3xl sm:text-5xl font-bold mb-6">Sentuhan Professional Untuk Kecantikan Abadi</h2>
                <p class="text-gray-600 text-base sm:text-lg mb-6 md:mb-8 leading-relaxed">
                    Berdiri sejak tahun 2015, Griya Savitri telah berkomitmen untuk memberikan layanan kecantikan terbaik bagi setiap pelanggan. Kami percaya bahwa setiap individu memiliki keunikan tersendiri yang layak untuk dirayakan.
                </p>
                <div class="space-y-4 mb-10">
                    <div class="flex items-center space-x-3">
                        <span class="w-6 h-6 bg-rosegold/10 text-rosegold rounded-full flex items-center justify-center text-sm font-bold">✓</span>
                        <span class="text-gray-700">Terapis & Stylist Bersertifikat</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <span class="w-6 h-6 bg-rosegold/10 text-rosegold rounded-full flex items-center justify-center text-sm font-bold">✓</span>
                        <span class="text-gray-700">Produk berkualitas tinggi & natural</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <span class="w-6 h-6 bg-rosegold/10 text-rosegold rounded-full flex items-center justify-center text-sm font-bold">✓</span>
                        <span class="text-gray-700">Suasana yang tenang & private</span>
                    </div>
                </div>
                <a href="services.php" class="text-rosegold font-bold border-b-2 border-rosegold pb-1 hover:text-opacity-70 transition-all">Explore Our Philosophy</a>
            </div>
        </div>
    </div>
</section>

<!-- Featured Services Preview -->
<section class="py-16 sm:py-24 bg-beige/30">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h3 class="text-rosegold font-semibold tracking-widest uppercase text-xs sm:text-sm mb-4">Layanan Unggulan</h3>
        <h2 class="text-3xl sm:text-5xl font-bold mb-10 md:mb-16">Pilihan Terbaik Di Griya Savitri</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
            <?php
            // Sample data (always show as fallback/featured)
            $featured = [
                ['name' => 'Hair Styling', 'desc' => 'Transformasi tampilan rambut dengan teknik terkini.', 'img' => 'https://images.unsplash.com/photo-1562322140-8baeececf3df?ixlib=rb-1.2.1&auto=format&fit=crop&w=400&q=80'],
                ['name' => 'Facial Spa', 'desc' => 'Perawatan wajah mendalam untuk kulit sehat bercahaya.', 'img' => 'https://images.unsplash.com/photo-1512290923902-8a9f81dc2069?ixlib=rb-1.2.1&auto=format&fit=crop&w=400&q=80'],
                ['name' => 'Body Massage', 'desc' => 'Relaksasi total untuk melepas penat dan kelelahan.', 'img' => 'https://images.unsplash.com/photo-1544161515-4ae6ce6db874?ixlib=rb-1.2.1&auto=format&fit=crop&w=400&q=80'],
            ];
            
            foreach($featured as $item): 
            ?>
            <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 group text-left">
                <div class="overflow-hidden">
                    <img src="<?php echo $item['img']; ?>" alt="<?php echo $item['name']; ?>" class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-500">
                </div>
                <div class="p-6 md:p-8">
                    <h3 class="text-xl md:text-2xl font-bold mb-2 md:mb-3"><?php echo $item['name']; ?></h3>
                    <p class="text-gray-600 text-sm md:text-base mb-4 md:mb-6"><?php echo $item['desc']; ?></p>
                    <a href="<?php echo get_wa_link($item['name']); ?>" target="_blank" class="text-rosegold font-semibold inline-flex items-center group-hover:translate-x-2 transition-transform">
                        Book Service <span class="ml-2">→</span>
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <?php if ($pdo): ?>
        <div class="mt-16">
            <a href="services.php" class="bg-gray-900 text-white px-10 py-4 rounded-full font-semibold hover:bg-gray-800 transition-all">Lihat Semua Layanan</a>
        </div>
        <?php endif; ?>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
