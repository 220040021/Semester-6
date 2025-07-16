import paramiko
import getpass

def ssh_client(host, port, username, password):
    try:
        # Membuat SSH client
        client = paramiko.SSHClient()

        # Menambahkan kunci host secara otomatis
        client.set_missing_host_key_policy(paramiko.AutoAddPolicy())

        # Melakukan koneksi ke server SSH
        client.connect(hostname=host, port=port, username=username, password=password)

        print("Koneksi SSH berhasil ke", host)

        while True:
            command = input("Masukkan perintah yang ingin dijalankan (atau ketik 'exit' untuk keluar): ")
            if command.lower() == 'exit':
                break

            stdin, stdout, stderr = client.exec_command(command)
            output = stdout.read().decode()
            error = stderr.read().decode()

            if output:
                print("Output:\n", output)
            if error:
                print("Error:\n", error)

        client.close()
        print("Koneksi ditutup.")

    except Exception as e:
        print(f"Terjadi kesalahan: {e}")

if __name__ == '__main__':
    host = input("Masukkan host: ")
    port = int(input("Masukkan port (biasanya 22): "))
    username = input("Masukkan username: ")
    password = getpass.getpass("Masukkan password: ")

    ssh_client(host, port, username, password)
