import numpy as np
from flask import Flask, request, jsonify, render_template
import pickle
# import logging
app = Flask(__name__)
# logging.basicConfig(level=logging.DEBUG) 
model = pickle.load(open('model.pkl', 'rb'))

@app.route('/')
def home():
    # app.logger.info('This is an info message')
    return render_template('index.html')

@app.route('/predict',methods=['POST'])
def predict():
    '''
    For rendering results on HTML GUI
    '''
    # print(request.form.values())
    job_profile_name_analysis = request.form.get('job_profile_name_analysis')
    #Here I will manually write code to convert job profile name in int
    attained_questions_analysis = float(request.form.get('attained_questions_analysis'))
    if(attained_questions_analysis==0):
        attained_questions_analysis=1
    score_analysis = float(request.form.get('score_analysis'))
    correctness=round((score_analysis*100)/attained_questions_analysis,2)
    data_to_predict=[attained_questions_analysis,score_analysis,correctness,job_profile_name_analysis]
    int_features = [float(x) for x in data_to_predict]
    # print("Values received from form:", int_features)
    final_features = [np.array(int_features)]
    predicted_performance = model.predict(final_features)

    if(predicted_performance[0]==0):
        output=' Needs Improvement'
    elif(predicted_performance[0]==1):
        output=' Extremely Poor'
    elif(predicted_performance[0]==2):
        output=' Very Poor'
    elif(predicted_performance[0]==3):
        output='Poor'
    elif(predicted_performance[0]==4):
        output=' Below Average'
    elif(predicted_performance[0]==5):
        output=' Average'
    elif(predicted_performance[0]==6):
        output='Above Average'
    elif(predicted_performance[0]==7):
        output=' Good'
    elif(predicted_performance[0]==8):
        output='Very Good'
    elif(predicted_performance[0]==9):
        output='Excellent'

    return render_template('index.html', prediction_text='Your performance is  {}'.format(output))

@app.route('/predict_api',methods=['POST'])
def predict_api():
    '''
    For direct API calls trought request
    '''
    data = request.get_json(force=True)
    prediction = model.predict([np.array(list(data.values()))])

    output = prediction[0]
    return jsonify(output)

if __name__ == "__main__":
    app.run(debug=True)