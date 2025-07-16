import socket 

server = socket.socket(socket.AF_INET, socket.SOCK_DGRAM)
server.bind(('localhost', 12345))

print("UDP Server ready...")
while True:
    data, addr = server.recvfrom(1024)
    print(f'From {addr}: {data.decode()}')
    server.sendto(f'ECHO: {data.decode()}'.encode(), addr)

# =======batas server udp
# client.udp
import socket

client = socket.socket(socket.AF_INET, socket.SOCK_DGRAM)
client.sendto(b'Halo UDP Server!', ('localhost', 12345))
data, _ = client.recvfrom(1024)
print("Diterima:", data.decode())