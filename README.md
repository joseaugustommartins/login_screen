# Projeto de Sistema de Login (FastAPI + PHP + PostgreSQL)

Este projeto é um sistema de login simples que combina backend em **FastAPI (Python)**, frontend em **PHP** e banco de dados **PostgreSQL**. O objetivo é demonstrar a integração entre tecnologias distintas e boas práticas de autenticação.

---

## 🚀 Tecnologias Utilizadas

- **Python 3.10+**
- **FastAPI**
- **PHP 7.4+**
- **PostgreSQL (via Docker)**
- **Docker Compose**
- **JWT para autenticação**
- **HTML/CSS (Frontend básico)**

---

## 📦 Estrutura do Projeto

projeto_login/
├── backend/ # FastAPI + lógica de autenticação
├── frontend/ # Interface PHP simples
├── docker-compose.yml
├── init.sql # Script de criação do banco e tabela users
├── guia_execucao_login_project.docx
└── README.md

yaml
Copiar
Editar

---

## 🐳 Executando o PostgreSQL com Docker

Certifique-se de ter o [Docker](https://www.docker.com/products/docker-desktop/) instalado. Depois:

```bash
docker-compose up -d
Isso iniciará o PostgreSQL com o banco seu_banco e a tabela users já criada com um usuário de teste:

Usuário: admin

Senha: admin123

⚙️ Executando o Backend (FastAPI)
Vá para a pasta backend:

bash
Copiar
Editar
cd projeto_login/backend
Crie e ative um ambiente virtual:

bash
Copiar
Editar
python -m venv venv
venv\Scripts\activate  # No Windows
Instale as dependências:

bash
Copiar
Editar
pip install -r ../requirements.txt
Execute o servidor:

bash
Copiar
Editar
uvicorn main:app --reload --host 127.0.0.1 --port 8000
🌐 Executando o Frontend (PHP)
Em outra janela do terminal, vá para a pasta frontend:

bash
Copiar
Editar
cd projeto_login/frontend
Execute o servidor PHP:

bash
Copiar
Editar
php -S localhost:8080
🧪 Acessos e Testes
Login Web: http://localhost:8080/login.php

API Docs (Swagger): http://localhost:8000/docs

🛡️ Segurança
A senha no banco está em texto simples por fins didáticos. Use hash (bcrypt) em ambientes reais.

📄 Licença
Este projeto é livre para fins educacionais. Personalize à vontade.
