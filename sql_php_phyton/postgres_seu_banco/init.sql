-- Criação da tabela users
CREATE TABLE IF NOT EXISTS users (
    id SERIAL PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Inserir um usuário de teste (senha: 123456)
INSERT INTO users (username, password, email) 
VALUES ('admin', 'admin123', 'admin@exemplo.com')
ON CONFLICT DO NOTHING;

-- Criação da tabela clientes
CREATE TABLE IF NOT EXISTS clientes (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(100) NOT NULL CHECK (char_length(nome) >= 10),
    email VARCHAR(100) NOT NULL UNIQUE CHECK (email ~* '^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\\.[A-Za-z]{2,}$'),
    telefone VARCHAR(20) CHECK (telefone ~ '^[0-9]{11,}$')
);