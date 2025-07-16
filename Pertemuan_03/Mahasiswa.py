class Mahasiswa:
    def __init__(self, nama, nim):
        self.nama = nama
        self.nim = nim

    def tampil_info(self):
        print(f"Nama: {self.nama}\nNIM: {self.nim}")

mhsl1 = Mahasiswa('Budi', '101')
mhsl2 = Mahasiswa('Andi', '122')
mhsl3 = Mahasiswa('Didi', '103')

mhsl1.tampil_info()
mhsl2.tampil_info()

mhs = []
mhs.append(Mahasiswa('Randi', '105'))

for data in mhs:
    data.tampil_info()