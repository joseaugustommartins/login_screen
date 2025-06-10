# models/product_model.py
from typing import Optional
from pydantic import BaseModel

class Produto(BaseModel):
    id: Optional[int] = None
    nome: str
    descricao: Optional[str] = None
    marca: Optional[str] = None
    valor: float
