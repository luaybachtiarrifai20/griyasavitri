<?php
// admin/manage-bookings.php
require_once 'auth_check.php';
require_once '../includes/functions.php';
require_once '../includes/db.php';

$message = "";

// Handle Status Update
if (isset($_GET['id']) && isset($_GET['status'])) {
    $id = $_GET['id'];
    $status = $_GET['status'];
    $stmt = $pdo->prepare("UPDATE appointments SET status = ? WHERE id = ?");
    $stmt->execute([$status, $id]);
    $message = "Appointment status updated to $status!";
}

// Fetch all bookings
$stmt = $pdo->query("SELECT a.*, s.name as service_name 
                      FROM appointments a 
                      LEFT JOIN services s ON a.service_id = s.id 
                      ORDER BY a.created_at DESC");
$bookings = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Bookings - Griya Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Montserrat', sans-serif; }</style>
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Sidebar -->
    <div class="fixed w-64 h-full bg-gray-900 shadow-xl hidden md:block">
        <div class="p-8 text-center border-b border-gray-800">
            <h1 class="text-white text-xl font-bold tracking-widest">GRIYA <span class="text-gray-400">ADMIN</span></h1>
        </div>
        <nav class="p-6 space-y-4">
            <a href="dashboard.php" class="block text-gray-400 hover:text-white px-4 py-3 transition-colors">Dashboard</a>
            <a href="manage-services.php" class="block text-gray-400 hover:text-white px-4 py-3 transition-colors">Manage Services</a>
            <a href="manage-bookings.php" class="block text-white bg-gray-800 px-4 py-3 rounded-xl font-semibold">Manage Bookings</a>
            <a href="logout.php" class="block text-red-400 hover:text-red-300 px-4 py-3 transition-colors pt-10">Logout</a>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="md:ml-64 p-8">
        <header class="mb-10">
            <h2 class="text-3xl font-bold text-gray-800">Manage Bookings</h2>
            <p class="text-gray-500">Track and respond to customer appointments.</p>
        </header>

        <?php if ($message): ?>
            <div class="bg-green-50 text-green-700 p-4 rounded-xl mb-8 border border-green-100">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 border-b border-gray-50">
                        <tr class="text-xs font-bold text-gray-400 uppercase tracking-widest">
                            <th class="px-8 py-6">Customer</th>
                            <th class="px-8 py-6">Service</th>
                            <th class="px-8 py-6">Appointment</th>
                            <th class="px-8 py-6">Status</th>
                            <th class="px-8 py-6">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        <?php foreach($bookings as $b): ?>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-8 py-6">
                                <p class="font-bold text-gray-800"><?php echo $b->customer_name; ?></p>
                                <p class="text-xs text-gray-400"><?php echo $b->customer_email; ?></p>
                                <p class="text-xs text-gray-400"><?php echo $b->customer_phone; ?></p>
                            </td>
                            <td class="px-8 py-6 font-medium text-gray-600">
                                <?php echo $b->service_name ?: 'Deleted Service'; ?>
                            </td>
                            <td class="px-8 py-6">
                                <p class="font-bold text-gray-800"><?php echo date('d M Y', strtotime($b->appointment_date)); ?></p>
                                <p class="text-xs text-gray-400"><?php echo date('H:i', strtotime($b->appointment_time)); ?></p>
                            </td>
                            <td class="px-8 py-6 text-center">
                                <span class="px-3 py-1 rounded-full text-xs font-bold uppercase
                                    <?php 
                                    echo $b->status == 'pending' ? 'bg-orange-100 text-orange-600' : 
                                        ($b->status == 'confirmed' ? 'bg-green-100 text-green-600' : 
                                        ($b->status == 'cancelled' ? 'bg-red-100 text-red-600' : 'bg-blue-100 text-blue-600')); 
                                    ?>">
                                    <?php echo $b->status; ?>
                                </span>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex space-x-2">
                                    <?php if ($b->status == 'pending'): ?>
                                        <a href="?id=<?php echo $b->id; ?>&status=confirmed" class="bg-green-500 text-white px-3 py-1 rounded text-xs font-bold hover:bg-green-600 transition-colors">Confirm</a>
                                        <a href="?id=<?php echo $b->id; ?>&status=cancelled" class="bg-red-500 text-white px-3 py-1 rounded text-xs font-bold hover:bg-red-600 transition-colors">Cancel</a>
                                    <?php elseif ($b->status == 'confirmed'): ?>
                                        <a href="?id=<?php echo $b->id; ?>&status=completed" class="bg-blue-500 text-white px-3 py-1 rounded text-xs font-bold hover:bg-blue-600 transition-colors">Mark Done</a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
