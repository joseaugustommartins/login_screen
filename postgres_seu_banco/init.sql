CREATE TABLE IF NOT EXISTS users (
    id SERIAL PRIMARY KEY,
    "user" VARCHAR NOT NULL UNIQUE,
    password VARCHAR NOT NULL
);

INSERT INTO users (id, "user", password) VALUES
(1, 'admin', 'admin123')
ON CONFLICT DO NOTHING;