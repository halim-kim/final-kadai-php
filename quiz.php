<?php
include 'header.php';
include 'function.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$pdo = getDbConnection();
$stmt = $pdo->query("SELECT * FROM questions");
$questions = $stmt->fetchAll();
?>
    <h1 class="text-2xl font-bold text-pink-500">クイズ</h1>
    <form id="quizForm" method="POST" action="submit_answers.php">
        <?php foreach ($questions as $question): ?>
            <div class="mb-4">
                <p class="text-black"><?php echo htmlspecialchars($question['question_text']); ?></p>
                <?php
                $stmt = $pdo->prepare("SELECT * FROM choices WHERE question_id = ?");
                $stmt->execute([$question['id']]);
                $choices = $stmt->fetchAll();
                ?>
                <?php foreach ($choices as $choice): ?>
                    <div>
                        <input type="radio" name="answers[<?php echo $question['id']; ?>]" value="<?php echo $choice['choice_value']; ?>" class="mr-2">
                        <span class="text-white"><?php echo htmlspecialchars($choice['choice_value'] . ') ' . $choice['choice_text']); ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
        <button type="submit" class="bg-orange-500 text-black px-4 py-2 rounded">送信</button>
    </form>
    <script id="questionsData" type="application/json"><?php echo json_encode($questions); ?></script>
<?php include 'footer.php'; ?>