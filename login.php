<?php
include 'header.php';
include 'function.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $pdo = getDbConnection();
    $stmt = $pdo->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        header("Location: index.php");
    } else {
        echo '<p class="text-white">存在しないユーザーかパスワードが間違っています。</p>';
    }
}
?>
    <h1 class="text-2xl font-bold text-pink-500">ログイン</h1>
    <form method="POST" action="login.php">
        <input type="text" name="username" placeholder="ユーザー名" class="border p-2 mb-2 w-full rounded">
        <input type="password" name="password" placeholder="パスワード" class="border p-2 mb-2 w-full rounded">
        <button type="submit" class="bg-orange-500 text-white px-4 py-2 rounded w-full">ログイン</button>
    </form>
<?php include 'footer.php'; ?>