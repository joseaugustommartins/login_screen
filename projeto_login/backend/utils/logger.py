import logging
from logging.handlers import RotatingFileHandler
import os

# Cria a pasta "logs" se não existir
os.makedirs("logs", exist_ok=True)

# Configura o logger
logger = logging.getLogger("app_logger")
logger.setLevel(logging.INFO)

# Rotação de arquivos: até 5MB por arquivo, mantendo 5 arquivos
handler = RotatingFileHandler("logs/app.log", maxBytes=5*1024*1024, backupCount=5)
formatter = logging.Formatter('%(asctime)s - %(levelname)s - %(message)s')

handler.setFormatter(formatter)
logger.addHandler(handler)
