import socket

server_socket = socket.socket()
server_socket.bind(('localhost', 12345))
server_socket.listen()

print(f'server listening ...')
conn, addr = server_socket.accept()
filename = conn.recv(1024).decode()
file=open("file_" + filename, 'wb')

while True:
    data = conn.recv(1024)
    if not data:
        break
    file.write(data)

file.close()
conn.close()