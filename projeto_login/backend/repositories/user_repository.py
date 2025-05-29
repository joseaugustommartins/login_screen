from database import get_connection

class UserRepository:
    @staticmethod
    def find_by_username(username: str):
        conn = get_connection()
        cur = conn.cursor()
        cur.execute("SELECT username, password FROM users WHERE username = %s", (username,))
        row = cur.fetchone()
        conn.close()
        if row:
            return {"username": row[0], "password": row[1]}
        return None

    @staticmethod
    def create_user(username: str, password: str):
        if UserRepository.find_by_username(username):
            raise Exception("Usuário já existe.")
        conn = get_connection()
        cur = conn.cursor()
        cur.execute("INSERT INTO users (username, password) VALUES (%s, %s)", (username, password))
        conn.commit()
        conn.close()
