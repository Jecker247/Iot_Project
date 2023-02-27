import threading
import sys
import os

class ClientHandler(threading.Thread):

    def __init__(self, connection, address):
        self.connection = connection
        self.address = address
        self.quit = False;
        self.commandsList = 'cd$change Directory#downloadFile$download a file from the Cloud#uploadFile$upload a file in the Cloud#listDirectory$show the contents of the corrent folder#EXIT$close the connection with the server'
        super(ClientHandler, self).__init__()
        
    def run(self):
        message = ''
        self.connection.send(self.getListCommands().encode('utf-8'))
        while message != 'EXIT' and self.quit != True:
            message = self.reciveData();
            print('\n',message, '[ IP: ',self.address[0], 'PORT: ', self.address[1],' ]')

            command = message.split('#')[0]
            respond = ''
            if command == 'downloadFile':
                file_Name = message.split('#')[1]
                respond = self.reciveFile(file_Name)
            elif command == 'uploadFile':
                file_Name = message.split('#')[1]
                self.sendFile(file_Name)
                respond = '+OK#'+command
            elif command == 'exit':
                respond = '+OK#'+command
            elif command == 'cd':
                try:
                    path = message.split('#')[1]
                    os.chdir(path)
                    respond = '+OK#'+command+'#'+str(os.getcwd())
                except:
                    respond = '-ERR#Path or Directory Not Valid'
            elif command =='listDirectory':
                try:
                    listDir = os.listdir(os.getcwd())
                    respond = '+OK#'+str(listDir)
                except:
                    respond = '-ERR#Problem with the Directory\'s Tree'
            elif command =='EXIT':
                self.quit = True;
                respond = '+OK#Connection Closed'
            else:  
                respond = '-ERR#Command Not Found'
            
            self.sendData(respond)
            
        print('Closing Client Connection with:', self.address[0], 'with port: ', self.address[1])
            
    def reciveData(self):
        message = self.connection.recv(1024)
        return message.decode('utf-8')

    def reciveByteData(self):
        message = self.connection.recv(1024)
        return message

    def sendData(self, data):
        try:
            self.connection.send(data.encode('utf-8'))
        except:
            print('===ERROR===:  ',str(sys.exc_info()[0]))
            return false

    def reciveFile(self, file_Name):
        respond = '+OK#'+'downloadFile'
        return respond

    def sendFile(self, file_Name):
        respond = '+OK#'+'uploadFile'
        return respond

    def getListCommands(self):
        return self.commandsList

