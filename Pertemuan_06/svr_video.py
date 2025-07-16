from flask import Flask, Response, render_template_string, request
import os
 
app = Flask(__name__)
 
VIDEO_PATH = 'assets/satya.mp4'
 
@app.route('/')
def index():
    return render_template_string('''
    <!doctype html>
    <html>
    <head><title>Video Streaming</title></head>
    <body>
        <h1>Video Streaming with Flask</h1>
        <video width="720" height="480" controls>
            <source src="{{ url_for('video') }}" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </body>
    </html>
    ''')
 
@app.route('/video')
def video():
    def generate():
        with open(VIDEO_PATH, "rb") as f:
            while chunk := f.read(1024 * 1024):
                yield chunk
 
    file_size = os.path.getsize(VIDEO_PATH)
    range_header = request.headers.get('Range', None)
   
    if range_header:
        byte_range = range_header.replace('bytes=', '').split('-')
        start = int(byte_range[0])
        end = int(byte_range[1]) if byte_range[1] else file_size - 1
        length = end - start + 1
        with open(VIDEO_PATH, 'rb') as f:
            f.seek(start)
            data = f.read(length)
        return Response(data, 206, mimetype='video/mp4', headers={
            'Content-Range': f'bytes {start}-{end}/{file_size}',
            'Accept-Ranges': 'bytes',
            'Content-Length': str(length),
        })
   
    return Response(generate(), mimetype='video/mp4')
 
if __name__ == '__main__':
    app.run(debug=True)