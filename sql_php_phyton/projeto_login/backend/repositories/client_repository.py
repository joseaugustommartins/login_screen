# repositories/client_repository.py
import psycopg2
from psycopg2.extras import RealDictCursor
from typing import List, Optional
from models.client_model import Cliente
from utils.logger import logger

class ClientRepository:
    def __init__(self, conn):
        self.conn = conn

    def get_all(self) -> List[Cliente]:
        with self.conn.cursor(cursor_factory=RealDictCursor) as cur:
            cur.execute('SELECT * FROM clientes')
            rows = cur.fetchall()
            return [Cliente(**row) for row in rows]

    def get_by_id(self, cliente_id: int) -> Optional[Cliente]:
        with self.conn.cursor(cursor_factory=RealDictCursor) as cur:
            cur.execute('SELECT * FROM clientes WHERE id = %s', (cliente_id,))
            row = cur.fetchone()
            return Cliente(**row) if row else None

    def create(self, cliente: Cliente) -> Cliente:
        with self.conn.cursor(cursor_factory=RealDictCursor) as cur:
            cur.execute('INSERT INTO clientes (nome, email, telefone) VALUES (%s, %s, %s) RETURNING *',
                        (cliente.nome, cliente.email, cliente.telefone))
            row = cur.fetchone()
            self.conn.commit()
            return Cliente(**row)

    def update(self, cliente_id: int, cliente: Cliente) -> Optional[Cliente]:
        with self.conn.cursor(cursor_factory=RealDictCursor) as cur:
            cur.execute('UPDATE clientes SET nome=%s, email=%s, telefone=%s WHERE id=%s RETURNING *',
                        (cliente.nome, cliente.email, cliente.telefone, cliente_id))
            row = cur.fetchone()
            self.conn.commit()
            return Cliente(**row) if row else None

    def delete(self, cliente_id: int) -> bool:
        with self.conn.cursor() as cur:
            cur.execute('DELETE FROM clientes WHERE id=%s', (cliente_id,))
            self.conn.commit()
            return cur.rowcount > 0
