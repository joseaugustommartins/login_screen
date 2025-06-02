# Sistema de Login com PHP, Python e PostgreSQL

Este é um sistema de login completo utilizando PHP para o frontend, Python para o backend e PostgreSQL como banco de dados. Todo o sistema roda em containers Docker, tornando fácil a configuração e execução.

## Pré-requisitos

Antes de começar, você precisa ter instalado em sua máquina:
- [Docker Desktop](https://www.docker.com/products/docker-desktop/)
- [Git](https://git-scm.com/downloads) (opcional)

## Estrutura do Projeto

```
sql_php/
├── docker-compose.yml
├── postgres_seu_banco/
│   └── init.sql
└── projeto_login/
    ├── frontend/
    │   ├── css/
    │   │   └── style.css
    │   ├── index.php
    │   ├── dashboard.php
    │   └── logout.php
    └── backend/
        ├── requirements.txt
        ├── database.py
        └── main.py
```

## Como Usar

1. **Clone o repositório ou baixe os arquivos**
   ```bash
   git clone <url-do-repositorio>
   cd Tela_Login
   ```

2. **Inicie o Docker Desktop**
   - Abra o Docker Desktop
   - Aguarde até que o ícone do Docker na barra de tarefas mostre "Docker Desktop is running"

3. **Configure os arquivos**
   - Certifique-se de que todos os arquivos estão nos diretórios corretos conforme a estrutura acima
   - Verifique se o arquivo `docker-compose.yml` está na pasta `sql_php`

4. **Inicie os containers**
   ```bash
   cd sql_php
   docker-compose down -v    # Para remover containers e volumes antigos
   docker-compose up -d      # Para iniciar todos os serviços
   ```

5. **Acesse o sistema**
   - Frontend (Tela de Login): http://localhost:8000
   - Backend Python: http://localhost:8001
   - Adminer (Gerenciador do Banco): http://localhost:8080

6. **Credenciais padrão**
   - Para a tela de login:
     - Usuário: admin
     - Senha: admin123

   - Para o Adminer (gerenciador do banco):
     - Sistema: PostgreSQL
     - Servidor: db
     - Usuário: postgres
     - Senha: admin
     - Base de dados: seu_banco

## Serviços Disponíveis

### Frontend (PHP)
- Porta: 8000
- Funcionalidades:
  - Tela de login responsiva
  - Validação de usuário
  - Dashboard protegido
  - Sistema de sessão
  - Logout

### Backend (Python)
- Porta: 8001
- Funcionalidades:
  - API REST
  - Conexão com PostgreSQL
  - Gerenciamento de usuários

### Banco de Dados (PostgreSQL)
- Porta: 5432
- Configurações:
  - Database: seu_banco
  - Usuário: postgres
  - Senha: admin

### Adminer
- Porta: 8080
- Interface web para gerenciar o banco de dados

## Comandos Úteis

1. **Iniciar os serviços**
   ```bash
   docker-compose up -d
   ```

2. **Parar os serviços**
   ```bash
   docker-compose down
   ```

3. **Reiniciar do zero (remove volumes)**
   ```bash
   docker-compose down -v
   docker-compose up -d
   ```

4. **Ver logs dos containers**
   ```bash
   # Todos os containers
   docker-compose logs

   # Container específico
   docker-compose logs php
   docker-compose logs python_backend
   docker-compose logs db
   ```

5. **Verificar status dos containers**
   ```bash
   docker-compose ps
   ```

## Solução de Problemas

1. **Erro de conexão com o banco**
   - Verifique se o Docker Desktop está rodando
   - Tente reiniciar os containers com `docker-compose down -v` seguido de `docker-compose up -d`

2. **Página não carrega**
   - Verifique se todos os containers estão rodando com `docker-compose ps`
   - Verifique os logs com `docker-compose logs`

3. **Erro de login**
   - Verifique se está usando as credenciais corretas
   - Verifique se o banco de dados foi inicializado corretamente através do Adminer

## Personalizando

1. **Adicionar novo usuário**
   - Acesse o Adminer (http://localhost:8080)
   - Faça login com as credenciais do PostgreSQL
   - Selecione a tabela "users"
   - Clique em "Novo item" e adicione os dados do usuário

2. **Modificar o estilo**
   - Edite o arquivo `frontend/css/style.css`

3. **Alterar configurações do banco**
   - Modifique as variáveis de ambiente no `docker-compose.yml`
   - Atualize o arquivo `init.sql` conforme necessário

## Segurança

- As senhas no banco de dados devem ser armazenadas com hash
- Mantenha as credenciais do banco seguras
- Não exponha as portas dos serviços diretamente à internet
- Use HTTPS em produção

## Suporte

Em caso de dúvidas ou problemas:
1. Verifique os logs dos containers
2. Consulte a documentação do Docker
3. Verifique as configurações do seu ambiente
