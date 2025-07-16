from flask import Flask, render_template, request, redirect, url_for, session, flash, jsonify
from flask_socketio import SocketIO, emit
from werkzeug.utils import secure_filename
import os, json, datetime, ssl
import pymysql

app = Flask(__name__)
app.secret_key = 'rahasia123'

socketio = SocketIO(app, async_mode='threading')

UPLOAD_FOLDER = 'static/uploads'
FOTO_FOLDER = 'static/images'
CHAT_FILE = 'chat.json'
os.makedirs(UPLOAD_FOLDER, exist_ok=True)
os.makedirs(FOTO_FOLDER, exist_ok=True)

# Koneksi ke MySQL
db = pymysql.connect(
    host="localhost",
    user="root",
    password="",
    database="chatdb"
)
cursor = db.cursor()

@app.route('/')
def index():
    return redirect('/login')

@app.route('/login', methods=['GET', 'POST'])
def login():
    if request.method == 'POST':
        username = request.form['username']
        password = request.form['password']
        action = request.form['action']

        if action == 'login':
            cursor.execute("SELECT * FROM users WHERE username=%s AND password=%s", (username, password))
            user = cursor.fetchone()
            if user:
                session['user'] = username
                return redirect(url_for('choose_contact'))
            else:
                flash('Login gagal. Cek username & password.')

        elif action == 'register':
            cursor.execute("SELECT * FROM users WHERE username=%s", (username,))
            if cursor.fetchone():
                flash('Username sudah digunakan.')
            else:
                cursor.execute("INSERT INTO users (username, password) VALUES (%s, %s)", (username, password))
                db.commit()
                flash('Registrasi berhasil. Silakan login.')

    return render_template('login.html')

@app.route('/logout')
def logout():
    session.pop('user', None)
    return redirect(url_for('login'))

@app.route('/chat')
def choose_contact():
    if 'user' not in session:
        return redirect(url_for('login'))
    user = session['user']
    cursor.execute("SELECT username FROM users WHERE username != %s", (user,))
    contacts = [row[0] for row in cursor.fetchall()]
    return render_template('home.html', user=user, contacts=contacts)

@app.route('/chat/<sender>/<receiver>', methods=['GET'])
def chat(sender, receiver):
    room = '-'.join(sorted([sender, receiver]))
    try:
        with open(CHAT_FILE, 'r') as f:
            history = json.load(f).get(room, [])
    except FileNotFoundError:
        history = []

    profile_path = os.path.join(FOTO_FOLDER, f'{receiver}.jpg')
    profile_file = f'{receiver}.jpg' if os.path.exists(profile_path) else 'user.jpg'

    return render_template('chat.html', sender=sender, receiver=receiver, history=history, profile_file=profile_file)

@socketio.on('send_message')
def handle_message(data):
    sender = data['sender']
    receiver = data['receiver']
    message = data['message']
    room = '-'.join(sorted([sender, receiver]))
    now = datetime.datetime.now().strftime('%H:%M')

    try:
        with open(CHAT_FILE, 'r') as f:
            chat_data = json.load(f)
    except FileNotFoundError:
        chat_data = {}

    chat_data.setdefault(room, []).append({
        "sender": sender,
        "message": message,
        "time": now
    })

    with open(CHAT_FILE, 'w') as f:
        json.dump(chat_data, f, indent=2)

    emit('receive_message', {
        "sender": sender,
        "message": message,
        "time": now
    }, broadcast=True)

@app.route('/upload/<sender>/<receiver>', methods=['POST'])
def upload(sender, receiver):
    room = '-'.join(sorted([sender, receiver]))
    file = request.files.get('file')
    if file:
        filename = secure_filename(file.filename)
        filepath = os.path.join(UPLOAD_FOLDER, filename)
        file.save(filepath)

        ext = filename.rsplit('.', 1)[-1].lower()
        if ext in ['png', 'jpg', 'jpeg', 'gif']:
            msg = f'<a href="/{filepath}" target="_blank"><img src="/{filepath}" width="150" style="border-radius:6px;"></a>'
        elif ext in ['mp4', 'webm', 'mov']:
            msg = f'<video src="/{filepath}" width="200" controls style="border-radius:6px;"></video>'
        elif ext in ['zip', 'rar', 'xlsx', 'xls', 'csv']:
            msg = f'<a href="/{filepath}" download style="color:#00ffff;">📎 {filename}</a>'
        else:
            msg = f'<a href="/{filepath}" target="_blank">{filename}</a>'

        now = datetime.datetime.now().strftime('%H:%M')

        try:
            with open(CHAT_FILE, 'r') as f:
                data = json.load(f)
        except FileNotFoundError:
            data = {}

        data.setdefault(room, []).append({"sender": sender, "message": msg, "time": now})
        with open(CHAT_FILE, 'w') as f:
            json.dump(data, f, indent=2)

        return jsonify({"message": msg})

    return jsonify({"message": ""}), 400

@app.route('/delete_chat', methods=['POST'])
def delete_chat():
    sender = request.form['sender']
    receiver = request.form['receiver']
    try:
        with open(CHAT_FILE, 'r') as file:
            chat_data = json.load(file)
    except FileNotFoundError:
        chat_data = {}
    room = '-'.join(sorted([sender, receiver]))
    chat_data.pop(room, None)
    with open(CHAT_FILE, 'w') as file:
        json.dump(chat_data, file, indent=4)
    return redirect(url_for('choose_contact'))

@app.route('/profile', methods=['GET', 'POST'])
def profile():
    if 'user' not in session:
        return redirect(url_for('login'))

    user = session['user']
    foto_filename = f"{user}.jpg"
    foto_path = os.path.join(FOTO_FOLDER, foto_filename)
    foto_url = url_for('static', filename=f'images/{foto_filename}')

    if request.method == 'POST':
        file = request.files.get('photo')
        if file:
            file.save(foto_path)
            flash("Foto profil berhasil diubah.")
            return redirect(url_for('profile'))

    if not os.path.exists(foto_path):
        foto_url = None

    return render_template('profile.html', user=user, user_photo_url=foto_url)

if __name__ == '__main__':
    context = ssl.SSLContext(ssl.PROTOCOL_TLS_SERVER)
    context.load_cert_chain('cert/cert.pem', 'cert/key.pem')
    socketio.run(app, host='0.0.0.0', port=5000, ssl_context=context)
