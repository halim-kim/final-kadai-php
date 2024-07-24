<?php
include 'header.php';
include 'function.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $pdo = getDbConnection();
    $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->execute([$username, $password]);

    header("Location: login.php");
}
?>
    <h1 class="text-2xl font-bold text-pink-500">登録</h1>
    <form method="POST" action="register.php">
        <input type="text" name="username" placeholder="ユーザー名" class="border p-2 mb-2 w-full rounded">
        <input type="password" name="password" placeholder="パスワード" class="border p-2 mb-2 w-full rounded">
        <button type="submit" class="bg-orange-500 text-black px-4 py-2 rounded w-full">登録</button>
    </form>
<?php include 'footer.php'; ?>