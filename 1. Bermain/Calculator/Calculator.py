import tkinter as tk
from tkinter import messagebox
import sqlite3

# Calculator Functions
def on_click(button):
    current = entry_var.get()
    entry_var.set(current + str(button))

def clear():
    entry_var.set("")

def calculate():
    try:
        result = eval(entry_var.get())
        entry_var.set(result)
    except:
        messagebox.showerror("Error", "Invalid Expression")

# GUI Setup
root = tk.Tk()
root.title("Simple Calculator")
root.geometry("300x400")

entry_var = tk.StringVar()
entry = tk.Entry(root, textvariable=entry_var, font=("Arial", 20), bd=10, relief=tk.GROOVE, justify="right")
entry.pack(fill=tk.BOTH)

buttons_frame = tk.Frame(root)
buttons_frame.pack()

buttons = [
    ('7', '8', '9', '/'),
    ('4', '5', '6', '*'),
    ('1', '2', '3', '-'),
    ('C', '0', '=', '+')
]

for row_values in buttons:
    row = tk.Frame(buttons_frame)
    row.pack(expand=True, fill=tk.BOTH)
    for value in row_values:
        btn = tk.Button(row, text=value, font=("Arial", 20), command=lambda v=value: on_click(v) if v not in ['C', '='] else clear() if v == 'C' else calculate())
        btn.pack(side=tk.LEFT, expand=True, fill=tk.BOTH)

root.mainloop()
