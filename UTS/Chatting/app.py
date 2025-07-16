from flask import Flask, render_template, request, send_from_directory
from flask_socketio import SocketIO, emit
from werkzeug.utils import secure_filename
import os
import ssl

UPLOAD_FOLDER = 'uploads'

app = Flask(__name__)
app.config['UPLOAD_FOLDER'] = UPLOAD_FOLDER
socketio = SocketIO(app)

@app.route('/')
def index():
    return render_template('index.html')

@app.route('/upload', methods=['POST'])
def upload():
    file = request.files['file']
    filename = secure_filename(file.filename)
    filepath = os.path.join(app.config['UPLOAD_FOLDER'], filename)
    file.save(filepath)
    socketio.emit('file_uploaded', {'filename': filename})
    return 'File uploaded successfully'

@app.route('/uploads/<filename>')
def uploaded_file(filename):
    return send_from_directory(app.config['UPLOAD_FOLDER'], filename)

@socketio.on('message')
def handle_message(data):
    username = data.get('username', 'Anonim')
    message = data.get('message', '')
    emit('message', {'username': username, 'message': message}, broadcast=True)

if __name__ == '__main__':
    os.makedirs(UPLOAD_FOLDER, exist_ok=True)
    context = ssl.SSLContext(ssl.PROTOCOL_TLS)
    context.load_cert_chain('cert/cert.pem', 'cert/key.pem')
    socketio.run(app, host='0.0.0.0', port=5000, ssl_context=context)