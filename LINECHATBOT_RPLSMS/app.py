import os
import time
from flask import Flask, request, abort, render_template,Response

from linebot import (
    LineBotApi, WebhookHandler
)
from linebot.exceptions import (
    InvalidSignatureError
)
from linebot.models import *

import datetime
import logging

import psycopg2
from flask_sqlalchemy import SQLAlchemy

app = Flask(__name__)
app.secret_key = 'earth12345'

#DB_URL = os.environ.get('DATABASE_URL')
# app.config['SQLALCHEMY_DATABASE_URI'] = DB_URL
# app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False # silence the deprecation warning

# db = SQLAlchemy(app)

DATABASE_URL = os.environ.get('DATABASE_URL')
conn = psycopg2.connect(DATABASE_URL, sslmode='require')
cursor = conn.cursor()
#conn = psycopg2.connect(DB_URL, sslmode='require')
conn.commit()
#Channel Access Token
CHANNEL_ACCESS_TOKEN = os.environ.get('CHANNEL_ACCESS_TOKEN')
CHANNEL_SECRET = os.environ.get('CHANNEL_SECRET')

line_bot_api = LineBotApi(CHANNEL_ACCESS_TOKEN)
handler = WebhookHandler(CHANNEL_SECRET)


# Post Listen to all the POST request from /callback, no need to change
@app.route("/callback", methods=['POST'])
def callback():
    # get X-Line-Signature header value
    signature = request.headers['X-Line-Signature']
    # get request body as text
    body = request.get_data(as_text=True)
    app.logger.info("Request body: " + body)
    # handle webhook body
    try:
        handler.handle(body, signature)
    except InvalidSignatureError:
        abort(400)
    return 'OK'

# Handle the messages and do the responding actions here.
@handler.add(MessageEvent, message=TextMessage)
def handle_message(event):
   profile = line_bot_api.get_profile(event.source.user_id)

   print(profile.display_name)
   print(profile.user_id)
   print(event.reply_token)
   #print(profile.picture_url)
   #print(profile.status_message)
   
   msg_from_user = event.message.text
   #get from db
   lot1 = 0 
   lot2 = 0
   cursor.execute("SELECT detect FROM park ORDER BY id DESC LIMIT 1")
   lot1 = str(cursor.fetchone()[0]) 
   cursor.execute("SELECT detect FROM park2 ORDER BY id DESC LIMIT 1")
   lot2 = str(cursor.fetchone()[0]) 
   text_message1 = TextSendMessage(text='ลานจอดรถจุด 1 \nมีจำนวนที่ว่างทั้งหมด: '+str(lot1))
   text_message2 = TextSendMessage(text='ลานจอดรถจุด 2 \nมีจำนวนที่ว่างทั้งหมด: '+str(lot2))
   if (msg_from_user == "1"):
        line_bot_api.reply_message(event.reply_token, text_message1)
        if(int(lot1)<=0):  #Full
                line_bot_api.multicast([profile.user_id], TextSendMessage(text='ขออภัยที่จอดเต็มแล้วครับ'))
        
        timeout = 120
        first_time = time.time()
        last_time = first_time
        while(True):
            if(int(lot1)<=0): #already full
                break
            cursor.execute("SELECT detect FROM park ORDER BY id DESC LIMIT 1")
            lot1full = str(cursor.fetchone()[0]) 
            new_time = time.time()
            if(int(lot1full)<=0):  #Full 
                print("Full PARKED!!!")
                line_bot_api.multicast([profile.user_id], TextSendMessage(text='ขออภัยที่จอดเต็มแล้วครับ'))
                break
            if  new_time - last_time > timeout:
                last_time = new_time
                print ("Its been {} sec. goodbye god",(new_time - first_time))
                break
        
        
   elif (msg_from_user == "2"):
        line_bot_api.reply_message(event.reply_token, text_message2)
        if(int(lot2)<=0):  #Full
                line_bot_api.multicast([profile.user_id], TextSendMessage(text='ขออภัยที่จอดเต็มแล้วครับ'))
        timeout = 120
        first_time = time.time()
        last_time = first_time
        while(True):
            if(int(lot2)<=0): #already full
                break
            cursor.execute("SELECT detect FROM park2 ORDER BY id DESC LIMIT 1")
            lot2full = str(cursor.fetchone()[0]) 
            new_time = time.time()
            if(int(lot2full)<=0):  #Full 
                print("Full PARKED!!!")
                line_bot_api.multicast([profile.user_id], TextSendMessage(text='ขออภัยที่จอดเต็มแล้วครับ'))
                break
            if  new_time - last_time > timeout:
                last_time = new_time
                print ("Its been {} sec. goodbye god",(new_time - first_time))
                break
            
   elif (msg_from_user == "map") or (msg_from_user == "location"):
        location_message = LocationSendMessage(
            title=' Arthada',
            address='197/78 Moo 8 T.Tungsukla Lamechabang Sriracha Chonburi 20230',
            latitude=13.11362,
            longitude=100.91986
        )
        line_bot_api.reply_message(event.reply_token, location_message)
   else:
        line_bot_api.reply_message(
            event.reply_token,
            TextSendMessage(
                text='เลือกคำสั่งที่ต้องการ',
                quick_reply=QuickReply(
                    items=[
                        QuickReplyButton(
                            action=MessageAction(label="ลานจอดรถจุดที่ 1", text="1")
                        ),
                        QuickReplyButton(
                            action=MessageAction(label="ลานจอดรถจุดที่ 2", text="2")
                        ),
                         QuickReplyButton(
                            action=MessageAction(label="แผนที่", text="location")
                        ),
                    ])))

if __name__ == "__main__":
    port = int(os.environ.get('PORT', 5000))
    app.run(host='0.0.0.0', port=port)
