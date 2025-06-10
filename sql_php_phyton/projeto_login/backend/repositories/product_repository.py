# repositories/product_repository.py
from typing import List, Optional
from models.product_model import Produto
from psycopg2.extras import RealDictCursor

class ProductRepository:
    def __init__(self, conn):
        self.conn = conn

    def get_all(self) -> List[Produto]:
        with self.conn.cursor(cursor_factory=RealDictCursor) as cur:
            cur.execute('SELECT * FROM produtos')
            rows = cur.fetchall()
            return [Produto(**row) for row in rows]

    def get_by_id(self, produto_id: int) -> Optional[Produto]:
        with self.conn.cursor(cursor_factory=RealDictCursor) as cur:
            cur.execute('SELECT * FROM produtos WHERE id = %s', (produto_id,))
            row = cur.fetchone()
            return Produto(**row) if row else None

    def create(self, produto: Produto) -> Produto:
        with self.conn.cursor(cursor_factory=RealDictCursor) as cur:
            cur.execute('INSERT INTO produtos (nome, descricao, marca, valor) VALUES (%s, %s, %s, %s) RETURNING *',
                        (produto.nome, produto.descricao, produto.marca, produto.valor))
            row = cur.fetchone()
            self.conn.commit()
            return Produto(**row)

    def update(self, produto_id: int, produto: Produto) -> Optional[Produto]:
        with self.conn.cursor(cursor_factory=RealDictCursor) as cur:
            cur.execute('UPDATE produtos SET nome=%s, descricao=%s, marca=%s, valor=%s WHERE id=%s RETURNING *',
                        (produto.nome, produto.descricao, produto.marca, produto.valor, produto_id))
            row = cur.fetchone()
            self.conn.commit()
            return Produto(**row) if row else None

    def delete(self, produto_id: int) -> bool:
        with self.conn.cursor() as cur:
            cur.execute('DELETE FROM produtos WHERE id=%s', (produto_id,))
            self.conn.commit()
            return cur.rowcount > 0
