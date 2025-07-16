with open('latihan1.txt','r') as file:
    for data in file:
        print(data.strip())
 
with open('latihan1.txt','r') as file:
    hasil=file.readlines()
    print(hasil)