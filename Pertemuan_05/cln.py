import socket
import os

client_socket = socket.socket()
client_socket.connect(('localhost',12345))

filename = 'file_logo_stikom.png'
client_socket.send(filename.encode())

with open(filename,'rb') as file:
    data = file.read(1024)
    while data:
        client_socket.send(data)
        data = file.read(1024)

client_socket.close()
print("File send")