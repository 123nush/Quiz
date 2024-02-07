from flask import Flask, request, jsonify
import joblib
import pandas as pd
from flask_cors import CORS

app = Flask(__name__)
CORS(app)
model = joblib.load('model.pkl')

@app.route('/predict', methods=['POST'])
def predict():
    try:
        data = request.json
        print("Received data:", data)  # Add this line to debug
        new_data = pd.DataFrame(data)
        predicted_performance = model.predict(new_data)
        return jsonify({'predicted_performance': predicted_performance.tolist()})
    except Exception as e:
        print("Error:", e)  # Add this line to debug
        return jsonify({'error': str(e)}), 500

if __name__ == '__main__':
    app.run(debug=True)
