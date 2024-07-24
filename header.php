<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>Talemuse</title>
    <link href="public/styles.css" rel="stylesheet">
</head>
<body class="bg-cover bg-center bg-fixed" style="background-image: url('img/background.png');">
    <div class="bg-black bg-opacity-90 p-4 border-b-2 border-orange-500">
        <div class="container mx-auto flex justify-between">
            <div>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="index.php" class="bg-orange-500 text-black px-4 py-2 rounded mr-4">ホーム</a>
                    <a href="mypage.php" class="bg-orange-500 text-black px-4 py-2 rounded mr-4">マイページ</a>
                    <a href="logout.php" class="bg-orange-500 text-black px-4 py-2 rounded">ログアウト</a>
                <?php else: ?>
                    <a href="index.php" class="bg-orange-500 text-black px-4 py-2 rounded mr-4">ホーム</a>
                    <a href="login.php" class="bg-orange-500 text-black px-4 py-2 rounded mr-4">ログイン</a>
                    <a href="register.php" class="bg-orange-500 text-black px-4 py-2 rounded">登録</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="container mx-auto mt-10 bg-orange-500 bg-opacity-70 p-6 rounded-lg">