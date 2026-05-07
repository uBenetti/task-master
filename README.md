# task-master

Um gerenciador simples de tarefas desenvolvido em PHP com SQLite que até o momento permite adicionar tarefas com título, descrição, data de vencimento e responsável.

## Funcionalidades Atuais

- Adicionar tarefas
- Definir descrição
- Definir data de vencimento
- Definir responsável
- Marcar tarefa como concluída
- Salvar no banco de dados local
- Excluir tarefas

## Tecnologias e ferramentas

- PHP
- SQLite
- HTML/CSS
- GitHub
- GitHub CodeSpace

## ▶️ Como executar

1. Clone o repositório:
   git clone github.com/uBenetti/task-master.git

2. Acesse a pasta:
   cd task-master

3. No terminal, inicie o servidor PHP:
   php -S localhost:8000

4. Acesse no navegador:
   http://localhost:8000

## Banco de Dados

O banco de dados (`tasks.sqlite`) é criado automaticamente ao executar o projeto pela primeira vez, por questões de segurança esse arquivo não é versionado no repositório.

## Estrutura commit atual (05/05/2026)

- index.php → lógica principal
- style.css → estilos
- tasks.sqlite → banco de dados (gerado automaticamente)

## 👨‍💻 Autores

Gustavo Avelino e Pedro Benetti