from ftplib import FTP
import getpass

def ftp_client(host, username, password):
    try:
        ftp = FTP(host)
        ftp.login(user=username, passwd=password)
        print(f"Berhasil login ke {host}")

        # Menampilkan file dan direktori
        ftp.retrlines('LIST')

        # Contoh mengunduh file
        nama_file = input("Masukkan nama file yang ingin diunduh (atau kosongkan untuk skip): ")
        if nama_file:
            with open(nama_file, 'wb') as f:
                ftp.retrbinary(f'RETR {nama_file}', f.write)
            print(f"File '{nama_file}' berhasil diunduh.")

        ftp.quit()
    except Exception as e:
        print("Terjadi kesalahan:", e)

if __name__ == '__main__':
    host = input("Masukkan host FTP (misal: localhost): ")
    username = input("Masukkan username FTP: ")
    password = getpass.getpass("Masukkan password FTP: ")

    ftp_client(host, username, password)
