import socket

sock = socket.socket()

print('Connection to server...')
sock.connect(('127.0.0.1', 5000))

print('connected to server')
message = ''.encode('utf-8')
listCommands = sock.recv(1024).decode('utf-8')
listCommands = listCommands.split('#')
print('\n\n==========COMMAND LIST:==========\n')
for item in listCommands:
    print('\t',item.split('$')[0],' -> ',item.split('$')[1])
print('\n')
while message != 'EXIT':
    message = str(input('>>> '))
    sock.send(message.encode('utf-8'))
    results = sock.recv(1024).decode('utf-8')
    print(results)
print('Connection closed')
