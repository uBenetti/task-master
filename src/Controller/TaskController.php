<?php

class TaskController {

    private $model;

    public function __construct(PDO $pdo) {

        $this->model = new Task($pdo);
    }

    // Página principal
    public function index($error = null) {

        $tasks = $this->model->getAll();

        require __DIR__ . '/../View/list.php';
    }

    // Criar tarefa
    public function create() {

        try {

            $this->model->save(

                $_POST['title'],
                $_POST['description'],
                $_POST['responsible'],
                $_POST['due_date']

            );

            header("Location: index.php");
            exit;

        } catch (Exception $e) {

            $this->index($e->getMessage());
        }
    }

    // Concluir tarefa
    public function complete() {

        $this->model->complete($_GET['id']);

        header("Location: index.php");
        exit;
    }

    // Excluir tarefa
    public function delete() {

        $this->model->delete($_GET['id']);

        header("Location: index.php");
        exit;
    }
}

?>