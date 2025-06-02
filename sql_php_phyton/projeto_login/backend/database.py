import psycopg2
from contextlib import contextmanager
import os

def get_connection():
    return psycopg2.connect(
        dbname=os.getenv('POSTGRES_DB', 'seu_banco'),
        user=os.getenv('POSTGRES_USER', 'postgres'),
        password=os.getenv('POSTGRES_PASSWORD', 'admin'),
        host=os.getenv('POSTGRES_HOST', 'db'),
        port=os.getenv('POSTGRES_PORT', '5432')
    )

@contextmanager
def get_db_cursor():
    conn = get_connection()
    try:
        yield conn.cursor()
        conn.commit()
    except Exception as e:
        conn.rollback()
        raise e
    finally:
        conn.close()
