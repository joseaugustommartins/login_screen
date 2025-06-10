# controllers/client_controller.py
from fastapi import APIRouter, Depends, HTTPException
from models.client_model import Cliente
from repositories.client_repository import ClientRepository
from database import get_db_cursor
from typing import List
from utils.logger import logger
import sys

router = APIRouter(prefix="/clientes", tags=["clientes"])

@router.get("/", response_model=List[Cliente])
def listar_clientes():
    with get_db_cursor() as cur:
        repo = ClientRepository(cur.connection)
        return repo.get_all()

@router.get("/{cliente_id}", response_model=Cliente)
def obter_cliente(cliente_id: int):
    with get_db_cursor() as cur:
        repo = ClientRepository(cur.connection)
        cliente = repo.get_by_id(cliente_id)
        if not cliente:
            raise HTTPException(status_code=404, detail="Cliente não encontrado")
        return cliente

@router.post("/", response_model=Cliente)
def criar_cliente(cliente: Cliente):
    try:
        with get_db_cursor() as cur:
            repo = ClientRepository(cur.connection)
            novo_cliente = repo.create(cliente)
            logger.info(f"Cliente inserido: {cliente.email}")
            print(f"Cliente inserido: {cliente.email}", file=sys.stderr)
            return novo_cliente
    except Exception as e:
        logger.error(f"Erro ao inserir cliente: {cliente.email} - {str(e)}")
        print(f"Erro ao inserir cliente: {cliente.email} - {str(e)}", file=sys.stderr)
        raise HTTPException(status_code=400, detail=str(e))

@router.put("/{cliente_id}", response_model=Cliente)
def atualizar_cliente(cliente_id: int, cliente: Cliente):
    with get_db_cursor() as cur:
        repo = ClientRepository(cur.connection)
        atualizado = repo.update(cliente_id, cliente)
        if not atualizado:
            raise HTTPException(status_code=404, detail="Cliente não encontrado")
        return atualizado

@router.delete("/{cliente_id}")
def deletar_cliente(cliente_id: int):
    with get_db_cursor() as cur:
        repo = ClientRepository(cur.connection)
        if not repo.delete(cliente_id):
            raise HTTPException(status_code=404, detail="Cliente não encontrado")
        return {"ok": True}
