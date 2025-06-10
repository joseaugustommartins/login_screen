# models/client_model.py
from typing import Optional
from pydantic import BaseModel

class Cliente(BaseModel):
    id: Optional[int] = None
    nome: str
    email: str
    telefone: Optional[str] = None
