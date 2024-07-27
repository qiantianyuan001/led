import requests
import json
import RPi.GPIO as GPIO
from time import sleep

url="http://www.qianty.online/led.php?method=get&name=led2"
# response = requests.post(url)
# data = json.loads(response.text)
# print(data['value'])
# print(data['message'])

GPIO.setmode(GPIO.BCM)
GPIO.setup(17,GPIO.OUT)
GPIO.setup(18,GPIO.OUT)
GPIO.setup(27,GPIO.OUT)
while True:
    response = requests.post(url)
    data = json.loads(response.text)
    if data['value']=='1': 
        GPIO.output(17, GPIO.HIGH)
        GPIO.output(18, GPIO.HIGH)
        GPIO.output(27, GPIO.HIGH)
    elif data['value']=='0':
        GPIO.output(17,GPIO.LOW)
        GPIO.output(18,GPIO.LOW)
        GPIO.output(27,GPIO.LOW)
    sleep(0.2)
GPIO.cleanup()
