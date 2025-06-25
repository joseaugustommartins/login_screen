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
-- Criação da tabela produtos (ajustada para CRUD de produtos.php)
DROP TABLE IF EXISTS produtos CASCADE;
CREATE TABLE IF NOT EXISTS produtos (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(100) NOT NULL CHECK (char_length(nome) >= 10),
    descricao TEXT NOT NULL CHECK (char_length(descricao) >= 20),
    marca VARCHAR(100) NOT NULL CHECK (char_length(marca) >= 5),
    valor DECIMAL(10,2) NOT NULL CHECK (valor > 1000)
);

-- Produto de exemplo (ajustado para seguir as regras)
INSERT INTO produtos (nome, valor, descricao, marca)
VALUES (
    'Produto Exemplo',
    1500.00,
    'Descrição de produto com mais de vinte caracteres.',
    'MarcaX'
)
ON CONFLICT DO NOTHING;