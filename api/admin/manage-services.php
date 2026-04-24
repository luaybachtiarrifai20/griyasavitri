<?php
// admin/manage-services.php
require_once 'auth_check.php';
require_once '../../includes/functions.php';
require_once '../../includes/db.php';

$message = "";

// Handle Delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM services WHERE id = ?");
    $stmt->execute([$id]);
    $message = "Service deleted successfully!";
}

// Handle Add/Edit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = sanitize($_POST['name']);
    $price = $_POST['price'];
    $duration = $_POST['duration'];
    $description = sanitize($_POST['description']);
    $image_path = sanitize($_POST['image_path']);

    if (isset($_POST['service_id']) && !empty($_POST['service_id'])) {
        // Update
        $id = $_POST['service_id'];
        $stmt = $pdo->prepare("UPDATE services SET name=?, price=?, duration=?, description=?, image_path=? WHERE id=?");
        $stmt->execute([$name, $price, $duration, $description, $image_path, $id]);
        $message = "Service updated successfully!";
    } else {
        // Add
        $stmt = $pdo->prepare("INSERT INTO services (name, price, duration, description, image_path) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$name, $price, $duration, $description, $image_path]);
        $message = "New service added!";
    }
}

// Fetch all services
$services = $pdo->query("SELECT * FROM services ORDER BY name ASC")->fetchAll();

// Fetch single service for edit
$edit_service = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM services WHERE id = ?");
    $stmt->execute([$_GET['edit']]);
    $edit_service = $stmt->fetch();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Services - Griya Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Montserrat', sans-serif; }</style>
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Sidebar (Simplified for brevity, same as dashboard) -->
    <div class="fixed w-64 h-full bg-gray-900 shadow-xl hidden md:block">
        <div class="p-8 text-center border-b border-gray-800">
            <h1 class="text-white text-xl font-bold tracking-widest">GRIYA <span class="text-gray-400">ADMIN</span></h1>
        </div>
        <nav class="p-6 space-y-4">
            <a href="dashboard.php" class="block text-gray-400 hover:text-white px-4 py-3 transition-colors">Dashboard</a>
            <a href="manage-services.php" class="block text-white bg-gray-800 px-4 py-3 rounded-xl font-semibold">Manage Services</a>
            <a href="manage-bookings.php" class="block text-gray-400 hover:text-white px-4 py-3 transition-colors">Manage Bookings</a>
            <a href="logout.php" class="block text-red-400 hover:text-red-300 px-4 py-3 transition-colors pt-10">Logout</a>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="md:ml-64 p-8">
        <header class="flex justify-between items-center mb-10">
            <h2 class="text-3xl font-bold text-gray-800">Manage Services</h2>
            <a href="manage-services.php#form" class="bg-gray-900 text-white px-6 py-2 rounded-xl text-sm font-bold">Add New Service</a>
        </header>

        <?php if ($message): ?>
            <div class="bg-green-50 text-green-700 p-4 rounded-xl mb-8 border border-green-100">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            <!-- Table Column -->
            <div class="lg:col-span-2 bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr class="text-xs font-bold text-gray-400 uppercase tracking-widest">
                            <th class="px-6 py-4">Service</th>
                            <th class="px-6 py-4">Price/Dur</th>
                            <th class="px-6 py-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        <?php foreach($services as $s): ?>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <p class="font-bold text-gray-800"><?php echo $s->name; ?></p>
                                <p class="text-xs text-gray-400 line-clamp-1"><?php echo $s->description; ?></p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="font-bold text-gray-800"><?php echo format_currency($s->price); ?></p>
                                <p class="text-xs text-gray-400"><?php echo $s->duration; ?> Min</p>
                            </td>
                            <td class="px-6 py-4 space-x-3">
                                <a href="?edit=<?php echo $s->id; ?>#form" class="text-blue-500 hover:underline text-sm font-bold">Edit</a>
                                <a href="?delete=<?php echo $s->id; ?>" onclick="return confirm('Yakin ingin menghapus?')" class="text-red-500 hover:underline text-sm font-bold">Delete</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Form Column -->
            <div id="form" class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                <h3 class="text-xl font-bold mb-6"><?php echo $edit_service ? 'Edit Service' : 'Add New Service'; ?></h3>
                <form method="POST" class="space-y-6">
                    <?php if ($edit_service): ?>
                        <input type="hidden" name="service_id" value="<?php echo $edit_service->id; ?>">
                    <?php endif; ?>
                    
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Service Name</label>
                        <input type="text" name="name" value="<?php echo $edit_service ? $edit_service->name : ''; ?>" required class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-100 focus:bg-white outline-none">
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Price (IDR)</label>
                            <input type="number" name="price" value="<?php echo $edit_service ? $edit_service->price : ''; ?>" required class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-100 focus:bg-white outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Dur (Min)</label>
                            <input type="number" name="duration" value="<?php echo $edit_service ? $edit_service->duration : ''; ?>" required class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-100 focus:bg-white outline-none">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Image URL (Optional)</label>
                        <input type="text" name="image_path" value="<?php echo $edit_service ? $edit_service->image_path : ''; ?>" class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-100 focus:bg-white outline-none" placeholder="https://...">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Description</label>
                        <textarea name="description" rows="4" required class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-100 focus:bg-white outline-none"><?php echo $edit_service ? $edit_service->description : ''; ?></textarea>
                    </div>

                    <button type="submit" class="w-full bg-gray-900 text-white py-4 rounded-xl font-bold shadow-lg shadow-gray-900/10">
                        <?php echo $edit_service ? 'Update Service' : 'Save Service'; ?>
                    </button>
                    
                    <?php if ($edit_service): ?>
                        <a href="manage-services.php" class="block text-center text-gray-400 text-sm mt-4">Cancel Edit</a>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
