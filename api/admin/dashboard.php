<?php
// admin/dashboard.php
require_once 'auth_check.php';
require_once '../includes/functions.php';
require_once '../includes/db.php';

// Stats for dashboard
$total_bookings = $pdo->query("SELECT COUNT(*) FROM appointments")->fetchColumn();
$pending_bookings = $pdo->query("SELECT COUNT(*) FROM appointments WHERE status = 'pending'")->fetchColumn();
$total_services = $pdo->query("SELECT COUNT(*) FROM services")->fetchColumn();

// Recent Bookings
$stmt_recent = $pdo->query("SELECT a.*, s.name as service_name 
                           FROM appointments a 
                           LEFT JOIN services s ON a.service_id = s.id 
                           ORDER BY a.created_at DESC LIMIT 5");
$recent_bookings = $stmt_recent->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Griya Admin</title>
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
            <a href="dashboard.php" class="block text-white bg-gray-800 px-4 py-3 rounded-xl font-semibold">Dashboard</a>
            <a href="manage-services.php" class="block text-gray-400 hover:text-white px-4 py-3 transition-colors">Manage Services</a>
            <a href="manage-bookings.php" class="block text-gray-400 hover:text-white px-4 py-3 transition-colors">Manage Bookings</a>
            <a href="logout.php" class="block text-red-400 hover:text-red-300 px-4 py-3 transition-colors pt-10">Logout</a>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="md:ml-64 p-8">
        <header class="flex justify-between items-center mb-10">
            <div>
                <h2 class="text-3xl font-bold text-gray-800">Overview</h2>
                <p class="text-gray-500">Welcome back, <?php echo $_SESSION['admin_name']; ?></p>
            </div>
            <div class="flex items-center space-x-4">
                <a href="../index.php" target="_blank" class="text-sm font-semibold text-gray-600 hover:text-gray-900">View Website ↗</a>
                <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center font-bold text-gray-600">
                    <?php echo strtoupper(substr($_SESSION['admin_name'], 0, 1)); ?>
                </div>
            </div>
        </header>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                <p class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-2">Total Bookings</p>
                <div class="flex items-baseline space-x-2">
                    <h3 class="text-4xl font-bold text-gray-800"><?php echo $total_bookings; ?></h3>
                    <span class="text-green-500 text-sm font-bold">LIFETIME</span>
                </div>
            </div>
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                <p class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-2">Pending Bookings</p>
                <div class="flex items-baseline space-x-2">
                    <h3 class="text-4xl font-bold text-orange-500"><?php echo $pending_bookings; ?></h3>
                    <span class="text-orange-400 text-sm font-bold">ACTION REQUIRED</span>
                </div>
            </div>
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                <p class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-2">Active Services</p>
                <div class="flex items-baseline space-x-2">
                    <h3 class="text-4xl font-bold text-blue-500"><?php echo $total_services; ?></h3>
                    <span class="text-blue-400 text-sm font-bold">ON MENU</span>
                </div>
            </div>
        </div>

        <!-- Recent Bookings Table -->
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-8 py-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                <h3 class="font-bold text-gray-800">Recent Appointments</h3>
                <a href="manage-bookings.php" class="text-sm font-semibold text-gray-500 hover:text-gray-900 underline">View all</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-sm font-bold text-gray-400 uppercase tracking-widest border-b border-gray-50">
                            <th class="px-8 py-6">Customer</th>
                            <th class="px-8 py-6">Service</th>
                            <th class="px-8 py-6">Date & Time</th>
                            <th class="px-8 py-6">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        <?php if (empty($recent_bookings)): ?>
                            <tr>
                                <td colspan="4" class="px-8 py-10 text-center text-gray-400">No appointments yet.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($recent_bookings as $booking): ?>
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-8 py-6">
                                        <p class="font-bold text-gray-800"><?php echo $booking->customer_name; ?></p>
                                        <p class="text-xs text-gray-400"><?php echo $booking->customer_phone; ?></p>
                                    </td>
                                    <td class="px-8 py-6 text-gray-600 font-medium">
                                        <?php echo $booking->service_name ?: 'Unknown Service'; ?>
                                    </td>
                                    <td class="px-8 py-6">
                                        <p class="text-gray-800 font-medium"><?php echo date('d M Y', strtotime($booking->appointment_date)); ?></p>
                                        <p class="text-xs text-gray-400"><?php echo date('H:i', strtotime($booking->appointment_time)); ?></p>
                                    </td>
                                    <td class="px-8 py-6">
                                        <span class="px-3 py-1 rounded-full text-xs font-bold uppercase
                                            <?php 
                                            echo $booking->status == 'pending' ? 'bg-orange-100 text-orange-600' : 
                                                ($booking->status == 'confirmed' ? 'bg-green-100 text-green-600' : 
                                                ($booking->status == 'cancelled' ? 'bg-red-100 text-red-600' : 'bg-gray-100 text-gray-600')); 
                                            ?>">
                                            <?php echo $booking->status; ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
