import jwt
from datetime import datetime, timedelta

SECRET = "minha_chave_secreta"

def create_jwt(username: str):
    payload = {
        "sub": username,
        "exp": datetime.utcnow() + timedelta(hours=1)
    }
    return jwt.encode(payload, SECRET, algorithm="HS256")