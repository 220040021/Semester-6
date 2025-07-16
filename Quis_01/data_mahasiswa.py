class Mahasiswa:
    def __init__(self, nim, nama, email, program_studi):
        self.nim = nim
        self.nama = nama
        self.email = email
        self.program_studi = program_studi

    def __str__(self):
        return f"NIM: {self.nim}\nNama: {self.nama}\nEmail: {self.email}\nProgram Studi: {self.program_studi}\n"

hasil = input("Masukkan nama anda: ")
with open('data_mahasiswa.txt', 'a') as file:
    file.write("Nama : " + hasil + "\n")
    file.write("--------------------------\n")

# Perulangan untuk memasukkan data 3 teman
total_teman = 3
mahasiswa_list = []
for i in range(total_teman):
    print(f"Masukkan data teman ke-{i+1}:")
    nim_teman = input("NIM: ")
    nama_teman = input("Nama: ")
    email_teman = input("Email: ")
    program_studi_teman = input("Program Studi: ")
    
    mahasiswa = Mahasiswa(nim_teman, nama_teman, email_teman, program_studi_teman)
    mahasiswa_list.append(mahasiswa)
    
    with open('data_mahasiswa.txt', 'a') as file:
        file.write(f"Teman {i+1}:\n")
        file.write(str(mahasiswa))
        file.write("--------------------------\n")
        
