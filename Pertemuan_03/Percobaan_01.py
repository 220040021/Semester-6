hasil = input("Masukkan nama anda: ")
with open('Percobaan_01.txt', 'a') as file:
    file.write("Nama : " + hasil + "\n")
    file.write("Belajar nulis python\n")
    file.write("Semoga bisa lancar\n")

# Perulangan untuk memasukkan data 3 teman
total_teman = 3
for i in range(total_teman):
    print(f"Masukkan data teman ke-{i+1}:")
    nama_teman = input("Nama: ")
    nim_teman = input("NIM: ")
    email_teman = input("Email: ")
    
    with open('latihan1.txt', 'a') as file:
        file.write(f"Teman {i+1}:\n")
        file.write(f"NIM: {nim_teman}\n")
        file.write(f"Nama: {nama_teman}\n")
        file.write(f"Email: {email_teman}\n")
        file.write("--------------------------\n")

with open('latihan1.txt', 'a') as file:
    file.write('Isian berikutnya\n')
    file.write('Daftar berikutnya\n')
