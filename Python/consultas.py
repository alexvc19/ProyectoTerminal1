import pymongo
from conection import conectar_mongo, cerrar_conexion

def verificar_credenciales(username, password):
    try:
        client = conectar_mongo()
        if client:
            db = client['VocabloDB']
            coleccion = db['Administrador']
            usuario_encontrado = coleccion.find_one({'usuario': username, 'contrasena': password})
            return usuario_encontrado is not None
        return False
    except Exception as e:
        return False
    finally:
        if client:
            cerrar_conexion(client)
