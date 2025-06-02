from fastapi import APIRouter, HTTPException, Depends
from models.user_model import UserLogin, UserRegister
from services.auth_service import AuthService
from utils.jwt_handler import get_current_user

router = APIRouter()

@router.post("/login")
def login(user: UserLogin):
    try:
        token = AuthService.login(user)
        return {"access_token": token, "token_type": "bearer"}
    except Exception as e:
        raise HTTPException(status_code=401, detail=str(e))

@router.post("/register")
def register(user: UserRegister):
    try:
        return AuthService.register(user)
    except Exception as e:
        raise HTTPException(status_code=400, detail=str(e))

@router.get("/me")
def get_user_info(username: str = Depends(get_current_user)):
    """Rota protegida que retorna informações do usuário atual"""
    return {"username": username, "message": "Você está autenticado!"}
