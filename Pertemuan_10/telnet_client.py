import telnetlib3
import asyncio

async def telnet_client(host, port):
    try:
        reader, writer = await telnetlib3.open_connection(host, port)
        print("Koneksi berhasil!")

        while True:
            command = input("Tuliskan perintah, exit untuk selesai ... ")

            if command.lower() == "exit":
                print("Koneksi ditutup")
                break

            writer.write(command + '\n')
            await writer.drain()

            response = await reader.read(1024)
            print(f"Response: {response}")

        writer.close()
        await writer.wait_closed()
        print("Koneksi ditutup")

    except Exception as e:
        print(f"Error: {e}")

if __name__ == '__main__':
    host = input("Masukkan nama host: ")
    port = int(input("Masukkan port: "))
    asyncio.run(telnet_client(host, port))
