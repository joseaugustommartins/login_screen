from fastapi import FastAPI
from controllers import auth_controller, product_controller
from fastapi import FastAPI, Request
from fastapi.responses import JSONResponse
from utils.logger import logger

app = FastAPI()

app.include_router(auth_controller.router)
app.include_router(product_controller.router)

@app.exception_handler(Exception)
async def global_exception_handler(request: Request, exc: Exception):
    logger.error(f"Erro em {request.url.path}: {str(exc)}")
    return JSONResponse(status_code=500, content={"detail": "Erro interno no servidor"})