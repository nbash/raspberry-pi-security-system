#!/usr/bin/env python3

import RPi.GPIO as GPIO
import time
import datetime
import os
import requests
from pushover import Client

# Constants
SENSOR_PIN_MAPPING = {
    'Basement': 5,
    'Garage': 6,
    'Front Door': 16,
    'Glass Break': 22,
    'Motion Basement': 23,
    'Kitchen': 24
}

# Initiate the GPIO
GPIO.setwarnings(False)
GPIO.setmode(GPIO.BCM)

for pin in SENSOR_PIN_MAPPING.values():
    GPIO.setup(pin, GPIO.IN, pull_up_down=GPIO.PUD_DOWN)

# Initialize sensor status
sensor_status = {sensor: 'closed' for sensor in SENSOR_PIN_MAPPING.keys()}

# Time range for sending message
start_hour = 23  # 11:00 PM
end_hour = 6  # 6:00 AM

def check_sensor_status(sensor, pin):
    if GPIO.input(pin) == 0:
        if sensor_status[sensor] == 'closed':
            sensor_status[sensor] = 'open'
            now = datetime.datetime.now().hour
            if start_hour <= now or now < end_hour:
                Client(user_key="API_USER", api_token="API_KEY").send_message(f"{sensor}", title="Home Security", priority= "1")
    elif GPIO.input(pin) == 1:
        if sensor_status[sensor] == 'open':
            sensor_status[sensor] = 'closed'

while True:
    with open("/var/www/html/security_status.txt", "r") as file:
        status = file.read().strip()
    if status == 'Arm':
        for sensor, pin in SENSOR_PIN_MAPPING.items():
            check_sensor_status(sensor, pin)
    time.sleep(0.2)
