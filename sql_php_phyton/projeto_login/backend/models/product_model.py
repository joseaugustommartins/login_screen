# models/product_model.py
from typing import Optional
from pydantic import BaseModel, validator

class Produto(BaseModel):
    id: Optional[int] = None
    nome: str
    descricao: str
    marca: str
    valor: float

    @validator('nome')
    def nome_min_length(cls, v):
        if not v or len(v.strip()) < 10:
            raise ValueError('O nome deve ter no mínimo 10 caracteres.')
        return v

    @validator('descricao')
    def descricao_min_length(cls, v):
        if not v or len(v.strip()) < 20:
            raise ValueError('A descrição deve ter no mínimo 20 caracteres.')
        return v

    @validator('marca')
    def marca_min_length(cls, v):
        if not v or len(v.strip()) < 5:
            raise ValueError('A marca deve ter no mínimo 5 caracteres.')
        return v

    @validator('valor')
    def valor_min_value(cls, v):
        if v is None or v <= 1000:
            raise ValueError('O valor deve ser maior que 1000.')
        return v
