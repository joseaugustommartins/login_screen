from database import get_db_cursor
from passlib.hash import pbkdf2_sha256

class UserRepository:
    @staticmethod
    def find_by_username(username: str):
        with get_db_cursor() as cur:
            cur.execute("SELECT username, password FROM users WHERE username = %s", (username,))
            row = cur.fetchone()
            if row:
                return {"username": row[0], "password": row[1]}
            return None

    @staticmethod
    def create_user(username: str, password: str):
        if UserRepository.find_by_username(username):
            raise Exception("Usuário já existe.")
        
        hashed_password = pbkdf2_sha256.hash(password)
        
        with get_db_cursor() as cur:
            cur.execute(
                "INSERT INTO users (username, password) VALUES (%s, %s)", 
                (username, hashed_password)
            )
