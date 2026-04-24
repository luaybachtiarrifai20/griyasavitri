<?php
require_once 'includes/functions.php';
require_once 'includes/db.php';
include 'includes/header.php';

// Fetch all services
$services = [];
if ($pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM services ORDER BY name ASC");
        $services = $stmt->fetchAll();
    } catch (PDOException $e) {
        $pdo = null; // Treat as offline
    }
}

// Fallback to dummy data if database is offline or empty
if (!$pdo || empty($services)) {
    $services = [
        (object)[
            'id' => 1,
            'name' => 'Hair Styling & Cutting',
            'description' => 'Potongan rambut modern dan stylish sesuai dengan bentuk wajah Anda untuk tampilan yang lebih fresh.',
            'price' => 150000,
            'duration' => 60,
            'image_path' => 'https://images.unsplash.com/photo-1560066984-138dadb4c035?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80'
        ],
        (object)[
            'id' => 2,
            'name' => 'Facial Treatment Premium',
            'description' => 'Perawatan wajah menyeluruh dengan produk premium untuk kulit lebih bersih, kencang, dan bercahaya.',
            'price' => 350000,
            'duration' => 90,
            'image_path' => 'https://images.unsplash.com/photo-1512290923902-8a9f81dc2069?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80'
        ],
        (object)[
            'id' => 3,
            'name' => 'Traditional Body Massage',
            'description' => 'Pijat tradisional untuk merilekskan otot yang tegang dan melancarkan sirkulasi darah ke seluruh tubuh.',
            'price' => 200000,
            'duration' => 120,
            'image_path' => 'https://images.unsplash.com/photo-1544161515-4ae6ce6db874?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80'
        ],
        (object)[
            'id' => 4,
            'name' => 'Pedicure & Manicure',
            'description' => 'Perawatan kuku tangan dan kaki agar bersih, sehat, dan cantik dengan pilihan kutek berkualitas.',
            'price' => 120000,
            'duration' => 45,
            'image_path' => 'https://images.unsplash.com/photo-1519014816548-bf5fe059798b?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80'
        ]
    ];
}
?>

<div class="pt-24 sm:pt-32 pb-16 sm:pb-24 bg-beige/30 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10 md:mb-16">
            <h3 class="text-rosegold font-semibold tracking-widest uppercase text-xs sm:text-sm mb-4">Our Services</h3>
            <h1 class="text-3xl sm:text-6xl font-bold">Menu Perawatan Kami</h1>
            <div class="w-16 sm:w-24 h-1 bg-rosegold mx-auto mt-4 sm:mt-6"></div>
        </div>

        <?php if (!$pdo): ?>
            <div class="bg-orange-50 border border-orange-100 p-4 rounded-xl mb-12 text-center text-sm text-orange-700">
                <p>⚠️ Sistem database offline. Menampilkan data demo. Silakan hubungi kami untuk informasi harga terbaru.</p>
            </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
            <?php foreach ($services as $service): ?>
                    <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 group">
                        <div class="relative h-64 overflow-hidden">
                            <img src="<?php echo $service->image_path ?: 'https://images.unsplash.com/photo-1521590832167-7bcbfaa6381f?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80'; ?>" alt="<?php echo $service->name; ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm px-4 py-2 rounded-full text-rosegold font-bold shadow-sm">
                                <?php echo format_currency($service->price); ?>
                            </div>
                        </div>
                        <div class="p-6 md:p-8">
                            <div class="flex justify-between items-start mb-3 md:mb-4">
                                <h3 class="text-xl md:text-2xl font-bold"><?php echo $service->name; ?></h3>
                                <span class="bg-gray-100 text-gray-600 px-3 py-1 rounded-md text-xs sm:text-sm"><?php echo $service->duration; ?> Min</span>
                            </div>
                            <p class="text-gray-600 text-sm md:text-base mb-6 md:mb-8 line-clamp-2"><?php echo $service->description; ?></p>
                            <a href="<?php echo get_wa_link($service->name); ?>" target="_blank" class="block w-full text-center bg-rosegold text-white py-3 md:py-4 rounded-xl font-bold text-sm md:text-base hover:bg-opacity-90 transition-all shadow-lg shadow-rosegold/20">
                                Book This Service
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
