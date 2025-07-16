from flask import Flask, Response, render_template_string
import cv2
 
app = Flask(__name__)
camera = cv2.VideoCapture(0)  # 0 untuk webcam lokal
 
def generate_frames():
    while True:
        success, frame = camera.read()
        if not success:
            break
        else:
            # Encode frame jadi JPEG
            ret, buffer = cv2.imencode('.jpg', frame)
            frame = buffer.tobytes()
 
            # Streaming multipart response
            yield (b'--frame\r\n'
                   b'Content-Type: image/jpeg\r\n\r\n' + frame + b'\r\n')
 
@app.route('/')
def index():
    return render_template_string('''
        <html>
            <head><title>Video Streaming</title></head>
            <body>
                <h1>Live Streaming</h1>
                <img src="{{ url_for('video') }}">
            </body>
        </html>
    ''')
 
@app.route('/video')
def video():
    return Response(generate_frames(), mimetype='multipart/x-mixed-replace; boundary=frame')
 
if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000, debug=True)