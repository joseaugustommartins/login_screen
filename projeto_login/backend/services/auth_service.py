from repositories.user_repository import UserRepository
from models.user_model import UserLogin, UserRegister
from utils.jwt_handler import create_jwt
from utils.logger import logger

class AuthService:
    @staticmethod
    def login(user: UserLogin):
        user_db = UserRepository.find_by_username(user.username)
        if not user_db or user.password != user_db["password"]:
            logger.warning(f"Tentativa de login falhou: {user.username}")
            raise Exception("Usuário ou senha inválidos")
        logger.info(f"Login realizado: {user.username}")
        return create_jwt(user.username)

    @staticmethod
    def register(user: UserRegister):
        UserRepository.create_user(user.username, user.password)
        logger.info(f"Usuário registrado: {user.username}")
        return {"message": "Usuário registrado com sucesso"}
