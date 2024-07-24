<?php
include 'header.php';
include 'function.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$pdo = getDbConnection();
$user_id = $_SESSION['user_id'];

// パートナーのIDを取得
$stmt = $pdo->prepare("SELECT partner_id FROM partners WHERE user_id = ?");
$stmt->execute([$user_id]);
$partner = $stmt->fetch();
$partner_id = $partner ? $partner['partner_id'] : null;

// 自分の回答を取得
$stmt = $pdo->prepare("
    SELECT q.id AS question_id, q.question_text, a.user_answer, c.choice_text
    FROM answers a
    JOIN questions q ON a.question_id = q.id
    JOIN choices c ON a.question_id = c.question_id AND a.user_answer = c.choice_value
    WHERE a.user_id = ?
    ORDER BY q.id
");
$stmt->execute([$user_id]);
$my_answers = $stmt->fetchAll(PDO::FETCH_GROUP|PDO::FETCH_UNIQUE);

// パートナーの回答を取得
$partner_answers = [];
if ($partner_id) {
    $stmt = $pdo->prepare("
        SELECT q.id AS question_id, q.question_text, a.user_answer, c.choice_text
        FROM answers a
        JOIN questions q ON a.question_id = q.id
        JOIN choices c ON a.question_id = c.question_id AND a.user_answer = c.choice_value
        WHERE a.user_id = ?
        ORDER BY q.id
    ");
    $stmt->execute([$partner_id]);
    $partner_answers = $stmt->fetchAll(PDO::FETCH_GROUP|PDO::FETCH_UNIQUE);
}
?>
    <h1 class="text-2xl font-bold text-pink-500">マイページ</h1>
    <h2 class="text-xl mt-4 text-pink-500">回答比較</h2>
    <?php $question_number = 1; ?>
    <?php foreach ($my_answers as $question_id => $my_answer): ?>
        <div class="mb-4">
            <p class="text-white"><?php echo $question_number . '. ' . htmlspecialchars($my_answer['question_text']); ?></p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <h3 class="text-lg font-bold text-pink-500">あなたの回答</h3>
                    <p class="text-black"><?php echo htmlspecialchars($my_answer['user_answer']); ?> - <?php echo htmlspecialchars($my_answer['choice_text']); ?></p>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-pink-500">パートナーの回答</h3>
                    <?php if (isset($partner_answers[$question_id])): ?>
                        <p class="text-black"><?php echo htmlspecialchars($partner_answers[$question_id]['user_answer']); ?> - <?php echo htmlspecialchars($partner_answers[$question_id]['choice_text']); ?></p>
                    <?php else: ?>
                        <p class="text-black">登録なし</p>
                    <?php endif; ?>
                </div>
            </div>
            <?php if (isset($partner_answers[$question_id])): ?>
                <?php if ($my_answer['user_answer'] == $partner_answers[$question_id]['user_answer']): ?>
                    <p class="bg-white text-red-500 text-xl font-bold px-4 py-2 rounded">一致</p>
                <?php else: ?>
                    <p class="text-blue-500 text-xl font-bold">不一致</p>
                <?php endif; ?>
            <?php endif; ?>
        </div>
        <?php $question_number++; ?>
    <?php endforeach; ?>

    <h2 class="text-xl mt-4 text-pink-500">パートナー登録</h2>
    <form method="POST" action="mypage.php">
        <input type="text" name="partner_username" placeholder="パートナーのユーザー名" class="border p-2 mb-2 w-full rounded">
        <button type="submit" class="bg-orange-500 text-black px-4 py-2 rounded w-full">登録</button>
    </form>
    <?php if (isset($error)): ?>
        <p class="text-red-500"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
<?php include 'footer.php'; ?>