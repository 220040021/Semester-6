hasil=input("Masukkan nama anda ")
with open('latihan1.txt','a') as file:
    file.write("Nama : " + hasil)
    file.write("\nBelajar nulis python\n")
    file.write("Semoga bisa lancar\n")
 
with open('latihan1.txt','a') as file:
    file.write('Isian berikutnya\n')
    file.write('Daftar berikutnya\n')