class Mobil:
    def __init__(self, merk, warna, cc):
        self.merk = merk
        self.warna = warna
        self.cc = cc

    def tampil_info(self):
        print(f"Merk: {self.merk}")
        print(f"Warna: {self.warna}")
        print(f"CC: {self.cc}")

# Membuat objek mobil
mobil1 = Mobil("Toyota", "Merah", 1500)
mobil2 = Mobil("Honda", "Biru", 1600)
mobil3 = Mobil("Suzuki", "Hitam", 1400)

# Menampilkan informasi mobil
mobil1.tampil_info()
print()  # Untuk memberi jarak
mobil2.tampil_info()
print()  # Untuk memberi jarak
mobil3.tampil_info()