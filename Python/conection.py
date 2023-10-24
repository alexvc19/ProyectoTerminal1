from pymongo import MongoClient

password = 'kAfntY15YnoAJKs5'

def conectar_mongo():
    try:
        uri = f"mongodb+srv://tester:{password}@cluster0.vjhlz.mongodb.net/?retryWrites=true&w=majority"
        client = MongoClient(uri)
        return client
    except Exception as e:
        print(e)
        return None 
    
def cerrar_conexion(client):   
    try:
        client.close()
    except Exception as e:
        print(e)

