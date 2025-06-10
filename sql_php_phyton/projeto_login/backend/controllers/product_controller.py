# controllers/product_controller.py
from fastapi import APIRouter, HTTPException
from models.product_model import Produto
from repositories.product_repository import ProductRepository
from database import get_db_cursor
from typing import List

router = APIRouter(prefix="/produtos", tags=["produtos"])

@router.get("/", response_model=List[Produto])
def listar_produtos():
    with get_db_cursor() as cur:
        repo = ProductRepository(cur.connection)
        return repo.get_all()

@router.get("/{produto_id}", response_model=Produto)
def obter_produto(produto_id: int):
    with get_db_cursor() as cur:
        repo = ProductRepository(cur.connection)
        produto = repo.get_by_id(produto_id)
        if not produto:
            raise HTTPException(status_code=404, detail="Produto não encontrado")
        return produto

@router.post("/", response_model=Produto)
def criar_produto(produto: Produto):
    try:
        with get_db_cursor() as cur:
            repo = ProductRepository(cur.connection)
            novo_produto = repo.create(produto)
            return novo_produto
    except Exception as e:
        raise HTTPException(status_code=400, detail=str(e))

@router.put("/{produto_id}", response_model=Produto)
def atualizar_produto(produto_id: int, produto: Produto):
    with get_db_cursor() as cur:
        repo = ProductRepository(cur.connection)
        atualizado = repo.update(produto_id, produto)
        if not atualizado:
            raise HTTPException(status_code=404, detail="Produto não encontrado")
        return atualizado

@router.delete("/{produto_id}")
def deletar_produto(produto_id: int):
    with get_db_cursor() as cur:
        repo = ProductRepository(cur.connection)
        if not repo.delete(produto_id):
            raise HTTPException(status_code=404, detail="Produto não encontrado")
        return {"ok": True}
