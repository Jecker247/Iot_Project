import socket
from ClientHandler import ClientHandler

sock = socket.socket()

sock.bind(('127.0.0.1', 2500))
print('Server Started, listening for Clients...')

sock.listen(100)

while True:
        connection, address = sock.accept()
        print('Connection made at IP: ', str(address[0]), 'and port: ', str(address[1]))
        print('passing off client...')
        client = ClientHandler(connection, address)
        client.start()
        
print('Closing server end connection...')
connection.close()
sock.close() 
