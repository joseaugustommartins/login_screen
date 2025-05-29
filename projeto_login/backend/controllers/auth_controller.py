from fastapi import APIRouter, HTTPException
from models.user_model import UserLogin, UserRegister
from services.auth_service import AuthService

router = APIRouter()

@router.post("/login")
def login(user: UserLogin):
    try:
        token = AuthService.login(user)
        return {"access_token": token}
    except Exception as e:
        raise HTTPException(status_code=401, detail=str(e))

@router.post("/register")
def register(user: UserRegister):
    try:
        return AuthService.register(user)
    except Exception as e:
        raise HTTPException(status_code=400, detail=str(e))
