import paramiko
import getpass

def ssh_client(host, port, username, password):
    try:
        client = paramiko.SSHClient()
        client.set_missing_host_key_policy(paramiko.AutoAddPolicy())
        client.connect(hostname=host, port=port, username=username, password=password)
        print(f"\n✅ Berhasil terhubung ke {host}\n")

        while True:
            command = input(">> Masukkan perintah ('exit' untuk keluar): ")
            if command.lower() == 'exit':
                print("❌ Menutup koneksi...")
                break

            stdin, stdout, stderr = client.exec_command(command)
            output = stdout.read().decode()
            error = stderr.read().decode()

            if output:
                print(f"📥 Output:\n{output}")
            if error:
                print(f"⚠️ Error:\n{error}")

        client.close()
        print("🔌 Koneksi SSH ditutup.")

    except Exception as e:
        print(f"🚨 Error: {e}")

if __name__ == "__main__":
    host = input("🔹 Masukkan alamat IP/host server: ")
    port = int(input("🔹 Masukkan port SSH (default 22): ") or "22")
    username = input("🔹 Masukkan username: ")
    password = getpass.getpass("🔹 Masukkan password: ")

    ssh_client(host, port, username, password)
