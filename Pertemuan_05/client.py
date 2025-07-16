import socket

client_socket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
client_socket.connect(('localhost', 12345))

client_socket.send('Halo Server!'.encode())
data = client_socket.recv(1024).decode()
print("Diterima dari server:", data)

client_socket.close()