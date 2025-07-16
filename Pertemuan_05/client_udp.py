import socket

client = socket.socket(socket.AF_INET, socket.SOCK_DGRAM)
client.sendto(b'Halo UDP Server!', ('localhost', 12345))
data, _ = client.recvfrom(1024)
print("Diterima:", data.decode())