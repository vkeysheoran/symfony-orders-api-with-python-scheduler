from apscheduler.schedulers.background import BackgroundScheduler
import requests
import json

url = "http://localhost:8888/orders-api-symfony/API/public/index.php/v1/create_delayed"

scheduler = BackgroundScheduler(daemon=True)
def deplayed_order():
    response = requests.request("GET", url)
    print(response.text)
scheduler.add_job(deplayed_order,'interval',seconds=5)

scheduler.start()
