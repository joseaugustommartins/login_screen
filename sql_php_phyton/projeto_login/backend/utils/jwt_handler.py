from datetime import datetime, timedelta
from jose import JWTError, jwt
from fastapi import HTTPException, Security
from fastapi.security import HTTPAuthorizationCredentials, HTTPBearer
from typing import Optional

# Configurações do JWT
SECRET_KEY = "minha_chave_secreta"  # Em produção, use variável de ambiente
ALGORITHM = "HS256"
ACCESS_TOKEN_EXPIRE_MINUTES = 60

security = HTTPBearer()

def create_jwt(username: str) -> str:
    """Cria um novo token JWT"""
    data = {
        "sub": username,
        "exp": datetime.utcnow() + timedelta(minutes=ACCESS_TOKEN_EXPIRE_MINUTES),
        "iat": datetime.utcnow()
    }
    return jwt.encode(data, SECRET_KEY, algorithm=ALGORITHM)

def verify_jwt(token: str) -> Optional[str]:
    """Verifica se o token JWT é válido e retorna o username"""
    try:
        payload = jwt.decode(token, SECRET_KEY, algorithms=[ALGORITHM])
        username: str = payload.get("sub")
        if username is None:
            raise HTTPException(status_code=401, detail="Token inválido")
        return username
    except JWTError:
        raise HTTPException(status_code=401, detail="Token inválido")

async def get_current_user(credentials: HTTPAuthorizationCredentials = Security(security)) -> str:
    """Middleware para obter o usuário atual a partir do token JWT"""
    return verify_jwt(credentials.credentials)