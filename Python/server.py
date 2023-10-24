import http.server
import socketserver
import json
from pymongo import MongoClient

# Conexión a la base de datos de MongoDB en Atlas
client = MongoClient("mongodb+srv://tester:kAfntY15YnoAJKs5@cluster0.vjhlz.mongodb.net/?retryWrites=true&w=majority")
db = client.VocabloDB
collection = db.Administrador

# Crear un manejador para las solicitudes
class MyHandler(http.server.SimpleHTTPRequestHandler):
    def do_POST(self):
        try:
            content_length = int(self.headers['Content-Length'])
            post_data = self.rfile.read(content_length)
            post_data = json.loads(post_data)

            usuario = post_data.get('usuario')
            contrasena = post_data.get('contrasena')

            # Realizar la consulta a la base de datos
            result = collection.find_one({"usuario": usuario, "contrasena": contrasena})

            if result:
                response = json.dumps({"message": "Inicio de sesión exitoso"})
            else:
                response = json.dumps({"message": "Credenciales incorrectas"})

            self.send_response(200)
            self.send_header('Content-type', 'application/json')
            self.end_headers()
            self.wfile.write(response.encode())
        except json.JSONDecodeError as e:
            # Manejar errores de JSON malformado
            self.send_error(400, f'Error de JSON: {e}')
        except Exception as e:
            # Manejar otras excepciones
            self.send_error(500, f'Error en el servidor: {e}')

# Configurar el servidor
PORT = 8000
handler = MyHandler

with socketserver.TCPServer(("", PORT), handler) as httpd:
    print("Servidor en el puerto", PORT)
    httpd.serve_forever()
