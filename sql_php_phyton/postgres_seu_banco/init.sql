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

-- =====================================
-- Criação da tabela produtos
CREATE TABLE IF NOT EXISTS produtos (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    preco DECIMAL(10,2) NOT NULL,
    descricao TEXT,
    imagem TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Produto de exemplo
INSERT INTO produtos (nome, preco, descricao)
VALUES (
    'Produto1',
    399.90,
    'Teste.')
ON CONFLICT DO NOTHING;