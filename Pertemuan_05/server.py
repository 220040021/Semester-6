import socket

server_socket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
server_socket.bind(('localhost', 12345))
server_socket.listen()

print("Server siap menerima koneksi...")
client_socket, addr = server_socket.accept()
print("Koneksi dari: {}".format(addr))

data = client_socket.recv(1024).decode()
print("Diterima dari client: ", data)
client_socket.send("Halo Client!".encode())

client_socket.close()
server_socket.close()