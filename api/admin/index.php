<?php
// admin/index.php
session_start();
require_once '../includes/functions.php';
require_once '../includes/db.php';

if (isset($_SESSION['admin_id'])) {
    redirect('dashboard.php');
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!$pdo) {
        $error = "Database tidak terhubung. Silakan hubungi pengembang.";
    } else {
        $username = sanitize($_POST['username']);
        $password = $_POST['password'];

        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user->password)) {
            $_SESSION['admin_id'] = $user->id;
            $_SESSION['admin_name'] = $user->username;
            redirect('dashboard.php');
        } else {
            $error = "Username atau password salah.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Griya Savitri</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <style>body { font-family: 'Montserrat', sans-serif; }</style>
</head>
<body class="bg-gray-50 h-screen flex items-center justify-center">
    <div class="max-w-md w-full px-6">
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">
            <div class="bg-gray-900 px-10 py-12 text-center">
                <h1 class="text-white text-3xl font-bold tracking-widest">GRIYA <span class="text-gray-400">ADMIN</span></h1>
                <p class="text-gray-500 mt-2">Login to manage your salon</p>
            </div>
            
            <div class="p-10">
                <?php if ($error): ?>
                    <div class="bg-red-50 text-red-600 p-4 rounded-xl border border-red-100 mb-8 text-sm text-center">
                        <?php echo $error; ?>
                    </div>
                <?php endif; ?>

                <form method="POST" class="space-y-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Username</label>
                        <input type="text" name="username" required class="w-full px-5 py-4 rounded-xl bg-gray-50 border border-gray-100 focus:bg-white focus:border-gray-900 transition-all outline-none" placeholder="Enter username">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Password</label>
                        <input type="password" name="password" required class="w-full px-5 py-4 rounded-xl bg-gray-50 border border-gray-100 focus:bg-white focus:border-gray-900 transition-all outline-none" placeholder="Enter password">
                    </div>
                    
                    <button type="submit" class="w-full bg-gray-900 text-white py-4 rounded-xl font-bold hover:bg-gray-800 transition-all shadow-xl shadow-gray-900/10 mt-4">
                        Access Dashboard
                    </button>
                    
                    <a href="../index.php" class="block text-center text-gray-400 hover:text-gray-600 transition-colors text-sm font-medium mt-6">
                        ← Back to public site
                    </a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
