<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'function.php';
$pdo = getDbConnection();
$user_id = $_SESSION['user_id'];
$answers = $_POST['answers'];

// 最新の回答を削除
$stmt = $pdo->prepare("DELETE FROM answers WHERE user_id = ?");
$stmt->execute([$user_id]);

// 新しい回答を挿入
foreach ($answers as $question_id => $user_answer) {
    $stmt = $pdo->prepare("INSERT INTO answers (user_id, question_id, user_answer) VALUES (?, ?, ?)");
    $stmt->execute([$user_id, $question_id, $user_answer]);
}

header("Location: results.php");
?>