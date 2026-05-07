<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Master - MVC</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container">

    <h1>Task Master (MVC Edition)</h1>

    <?php if (isset($error)): ?>
        <div class="error">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>

    <form method="POST"
          action="index.php?action=create"
          class="form-group">

        <input type="text"
               name="title"
               placeholder="Tarefa:"
               required>

        <textarea name="description"
                  placeholder="Descrição (opcional): ">
        </textarea>

        <input type="text"
               name="responsible"
               placeholder="Responsável:"
               required>

        <input type="date"
               name="due_date"
               class="calendario"
               required>

        <button type="submit">
            Adicionar
        </button>
    </form>

    <ul>

        <?php foreach ($tasks as $task): ?>

            <li class="<?php echo $task['done'] ? 'done' : ''; ?>">

                <div>

                    <strong>
                        <?php echo htmlspecialchars($task['title']); ?>
                    </strong>

                    <br>

                    <small>
                        Obs:
                        <?php
                        echo htmlspecialchars(
                            $task['description']
                            ?: 'Sem descrição'
                        );
                        ?>
                    </small>

                    <br>

                    Vence em:
                    <?php echo htmlspecialchars($task['due_date']); ?>

                    <br>

                    Responsável:
                    <?php echo htmlspecialchars($task['responsible']); ?>

                </div>

                <div class="actions">

                    <?php if (!$task['done']): ?>

                        <a href="index.php?action=complete&id=<?php echo $task['id']; ?>"
                           title="Concluir">

                            ✅

                        </a>

                    <?php endif; ?>

                    <a href="index.php?action=delete&id=<?php echo $task['id']; ?>"
                       onclick="return confirm('Tem certeza que deseja excluir esta tarefa?');"
                       title="Excluir">

                        ❌

                    </a>

                </div>

            </li>

        <?php endforeach; ?>

    </ul>

</div>

</body>
</html>