<?php
include 'header.php';
include 'function.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$pdo = getDbConnection();
$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("
    SELECT q.question_text, a.user_answer, q.correct_answer, c.choice_text
    FROM answers a
    JOIN questions q ON a.question_id = q.id
    JOIN choices c ON a.question_id = c.question_id AND a.user_answer = c.choice_value
    WHERE a.user_id = ?
");
$stmt->execute([$user_id]);
$results = $stmt->fetchAll();
?>
    <h1 class="text-2xl font-bold text-pink-500">結果</h1>
    <?php foreach ($results as $result): ?>
        <div class="mb-4">
            <p class="text-white">質問: <?php echo htmlspecialchars($result['question_text']); ?></p>
            <p class="text-white">あなたの回答: <?php echo htmlspecialchars($result['user_answer']); ?> - <?php echo htmlspecialchars($result['choice_text']); ?></p>
            <p class="text-white">正解: <?php echo htmlspecialchars($result['correct_answer']); ?></p>
        </div>
    <?php endforeach; ?>
<?php include 'footer.php'; ?>