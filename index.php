<?php
$dbFile = __DIR__ . '/tasks.sqlite';
$pdo = new PDO('sqlite:' . $dbFile);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$pdo->exec("CREATE TABLE IF NOT EXISTS tasks (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title TEXT NOT NULL,
    description TEXT,
    due_date TEXT NOT NULL,
    responsible TEXT NOT NULL,
    done INTEGER DEFAULT 0
)");

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['title'])) {
    $title = trim($_POST['title']);
    $description = $_POST['description'] ?? '';
    $due_date = $_POST['due_date'] ?? '';
    $responsible = trim($_POST['responsible'] ?? '');
    if (empty($title) || empty($due_date) || empty($responsible)) {
        $error = "Título, responsável e data de vencimento são obrigatórios!";
    } else {
        $stmt = $pdo->prepare("
        INSERT INTO tasks (title, description, due_date, responsible)
        VALUES (:title, :description, :due_date, :responsible)
    ");
        $stmt->bindValue(':title', $title);
        $stmt->bindValue(':description', $description);
        $stmt->bindValue(':due_date', $due_date);
        $stmt->bindValue(':responsible', $responsible);

        $stmt->execute();
    }
}

if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    
    if ($_GET['action'] === 'complete') {
        $pdo->exec("UPDATE tasks SET done = 1 WHERE id = $id");
    } elseif ($_GET['action'] === 'delete') {
        $pdo->exec("DELETE FROM tasks WHERE id = $id");
    }
    
    header("Location: index.php");
    exit;
}

$stmt = $pdo->query("SELECT * FROM tasks ORDER BY id DESC");
$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Master - Spaghetti</title>
    <link rel="stylesheet" href="style.css">
    </head>
<body>

<div class="container">
    <h1>Task Master</h1>

    <?php if ($error): ?>
        <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST" action="index.php" class="form-group">
        <input type="text" name="title" placeholder="Tarefa:" required>
        <textarea name="description" placeholder="Descrição (opcional): "></textarea>
        <input type="text" name="responsible" placeholder="Responsável: " required>
        <input type="date" name="due_date" class="calendário" required>
        <button type="submit">Adicionar</button>
    </form>

    <ul>
        <?php foreach ($tasks as $task): ?>
            <li class="<?php echo $task['done'] ? 'done' : ''; ?>">
                <div>
                    <strong><?php echo htmlspecialchars($task['title']); ?></strong><br>

                    <small>
                        Obs: <?php echo htmlspecialchars($task['description'] ?: 'Sem descrição'); ?>
                    </small><br>

                    <?php echo htmlspecialchars($task['due_date']); ?><br>
                    Responsável: <?php echo htmlspecialchars($task['responsible']); ?>
                </div>
                
                <div class="actions">
                    <?php if (!$task['done']): ?>
                        <a href="?action=complete&id=<?php echo $task['id']; ?>" title="Concluir">✅</a>
                    <?php endif; ?>
                    <a href="?action=delete&id=<?php echo $task['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir esta tarefa?');" title="Excluir">❌</a>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

</body>
</html>