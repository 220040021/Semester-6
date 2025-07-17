import time
import sys

# Delay untuk setiap baris lirik
delay = [0.3, 0.9, 0.4, 0.3, 1.0, 0.7, 0.7, 0.5, 0.2, 0.4, 0.3, 0.4]

# Lirik lagu
lirik = [
    "Aduh, abang bukan maksudku begitu",
    "Masalah stecu bukan brarti tak mau",
    "Jual mahal dikit kan bisa",
    "Coba kasih effort-nya saja",
    "Kalo memang cocok bisa datang ke rumah",
    "",
    "Stecu stecu stelan cuek baru malu",
    "Adu ade ini mau juga abang yang rayu",
    "Stecu stecu stelan cuek baru malu",
    "Adu ade ini m..."
]

# Menampilkan judul
print("\n== Stecu-Stecu - Viral==")

# Menampilkan lirik dengan efek ketikan
for i, (baris_lagu, delay_karakter) in enumerate(zip(lirik, delay)):
    for karakter in baris_lagu:
        print(karakter, end='')
        sys.stdout.flush()
        time.sleep(delay_karakter)
    print('')
    time.sleep(delay[i])

print("===coba=== ===by intor.id=== (Ibrahim s)")
