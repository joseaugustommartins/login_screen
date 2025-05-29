# Login Project - Sistema de Login com FastAPI e PHP

Este projeto implementa um sistema de login simples, com um backend desenvolvido em FastAPI (Python) e um frontend em PHP. Ele demonstra a integração entre as duas tecnologias para autenticação de usuários.

## Visão Geral

O projeto consiste em duas partes principais:

* **Backend (FastAPI):** Responsável por gerenciar as rotas da API, incluindo a autenticação de usuários.
* **Frontend (PHP):** Interface de usuário para o formulário de login.

## Tecnologias Utilizadas

* **Python** (versão 3.10 ou superior) [cite: 4]
* **FastAPI**
* **PHP** (versão 7.4 ou superior) [cite: 4]
* **PostgreSQL** (via Docker)
* **Docker** e **Docker Compose**
* **pip** (gerenciador de pacotes Python, instalado junto com Python) [cite: 4]
* **PyJWT** [cite: 7]

## Pré-requisitos

Certifique-se de ter as seguintes ferramentas instaladas em sua máquina:

* [Python 3.10 ou superior](https://www.python.org/downloads/) [cite: 4]
* [PHP 7.4 ou superior](https://windows.php.net/download) [cite: 4]
* [Docker Desktop](https://www.docker.com/products/docker-desktop) (que inclui Docker Compose)

## Configuração do Banco de Dados (PostgreSQL com Docker Compose)

Para facilitar a configuração do banco de dados PostgreSQL, utilize o Docker Compose. O setup já inclui a criação da tabela `users` e um usuário inicial.

1.  Navegue até a pasta `postgres_seu_banco` dentro do seu projeto.
2.  Crie um arquivo chamado `docker-compose.yml` e adicione o seguinte conteúdo:

    ```yaml
    version: '3.8'
    services:
      db:
        image: postgres:latest
        container_name: postgres_seu_banco
        restart: unless-stopped
        environment:
          POSTGRES_DB: seu_banco
          POSTGRES_USER: postgres
          POSTGRES_PASSWORD: postgres_password  # você pode trocar aqui
        volumes:
          - pgdata:/var/lib/postgresql/data
          - ./init.sql:/docker-entrypoint-initdb.d/init.sql:ro
        ports:
          - "5432:5432"
    volumes:
      pgdata:
    ```

3.  No **mesmo diretório** da pasta `postgres_seu_banco`, crie um arquivo chamado `init.sql` e adicione o seguinte conteúdo:

    ```sql
    CREATE TABLE IF NOT EXISTS users (
        id SERIAL PRIMARY KEY,
        "user" VARCHAR NOT NULL UNIQUE,
        password VARCHAR NOT NULL
    );
    INSERT INTO users (id, "user", password) VALUES
    (1, 'admin', 'admin123')
    ON CONFLICT DO NOTHING;
    ```

4.  Para iniciar o contêiner do PostgreSQL, execute o seguinte comando na pasta `postgres_seu_banco`:
    ```bash
    docker-compose up -d
    ```
    Este comando irá baixar a imagem do PostgreSQL, criar e iniciar o contêiner, e executar o script `init.sql` para configurar a tabela `users` e inserir um usuário inicial.

## Extração do Projeto

1.  Extraia o arquivo `login_project.zip` para uma pasta de sua escolha. [cite: 1, 4]
    Exemplo: `C:\meu_projeto\login_project` [cite: 2, 5]

## Executando o Backend (FastAPI)

1.  Abra o terminal CMD e navegue até a pasta `backend`:
    ```bash
    cd C:\meu_projeto\login_project\backend
    ```
2.  Crie um ambiente virtual: [cite: 6]
    ```bash
    python -m venv venv
    ```
3.  Ative o ambiente virtual: [cite: 6]
    ```bash
    venv\Scripts\activate
    ```
4.  Instale as dependências: [cite: 7]
    ```bash
    pip install -r ..\requirements.txt
    pip install PyJWT
    ```
5.  Inicie o servidor FastAPI: [cite: 7]
    ```bash
    uvicorn main:app --reload --host 127.0.0.1 --port 8000
    ```

## Executando o Frontend (PHP)

1.  Em outra janela do CMD, vá para a pasta `frontend`: [cite: 8]
    ```bash
    cd C:\meu_projeto\login_project\frontend
    ```
2.  Inicie o servidor PHP: [cite: 8]
    ```bash
    php -S localhost:8080
    ```

## Acessos e Testes

Após iniciar ambos os servidores e o contêiner do PostgreSQL, você pode acessar:

* **Formulário de Login:** `http://localhost:8080/login.php` [cite: 3, 8]
* **Documentação da API FastAPI:** `http://localhost:8000/docs` [cite: 3, 8]

### Credenciais de Teste

Utilize as seguintes credenciais para testar o login (já inseridas via `init.sql` no Docker Compose):

* **Usuário:** `admin` [cite: 3, 8]
* **Senha:** `admin123` [cite: 3, 8]

## Contribuição

Sinta-se à vontade para contribuir com este projeto. Por favor, crie uma "issue" para quaisquer sugestões ou bugs encontrados, ou envie um "pull request" com suas melhorias.

## Licença

Este projeto está licenciado sob a licença [MIT](https://opensource.org/licenses/MIT).
