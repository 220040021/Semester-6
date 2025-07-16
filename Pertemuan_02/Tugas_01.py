# Membuat list kosong untuk menyimpan nama
nama_list = []

# Meminta input 5 nama dari pengguna
for i in range(5):
    nama = input(f"Masukkan nama teman ke-{i+1}: ")
    nama_list.append(nama)  # Menambahkan nama ke dalam list

# Menampilkan hasilnya
print("\nDaftar nama teman:")
for i, nama in enumerate(nama_list, start=1):
    print(f"{i}. {nama}")
