
#Commande pour lancer flask AWS
# SET GLOBAL innodb_lock_wait_timeout = 5000;
# SET innodb_lock_wait_timeout = 5000; 
# source ~/yougo/env/bin/activate
# export FLASK_APP=api
# export FLASK_ENV=development
# nohup python api.py &

import json
import mysql.connector
from flask import Flask
import pymysql

pymysql.install_as_MySQLdb()

app = Flask(__name__)

def connect_db():
    engine = mysql.connector.connect(host='yougo-db.c6mihiou3qzx.us-east-1.rds.amazonaws.com',
            database='yougodb',
            user='admin',
            password='azertyuiop')
    return engine

@app.route('/venue')
def get_all_venue():
    connection = connect_db()
    select = "select * from venue"
    cursor = connection.cursor(dictionary=True)
    cursor.execute(select)
    resultat = cursor.fetchall()
    return json.dumps(resultat)


@app.route('/venue/<id>/hours')
def get_all_hour_by_address(id=str):
    connection = connect_db()
    select = "select hour,day_row,intensity_txt,v.venue_id from hours_analysis h inner join venue v on v.venue_id=h.venue_id where v.venue_id= %s ORDER BY hour"
    cursor = connection.cursor(dictionary=True)
    cursor.execute(select, (id,))
    resultat = cursor.fetchall()
    return json.dumps(resultat)


@app.route('/venue/<address>')
def get_all_tag_by_address(address=str):
    connection = connect_db()
    select = "select * from venue v inner join venue_type_has_venue a on a.venue_id=v.venue_id inner join venue_type k on a.venue_type_id=k.type_id where v.venue_address= %s"
    cursor = connection.cursor(dictionary=True)
    cursor.execute(select, (address,))
    resultat = cursor.fetchall()
    return json.dumps(resultat)

@app.route('add/<address>')
def add_venue(address=str):
    connection = connect_db()
    venue_name = request.args.get('venue_name')
    venue_lon = request.args.get('venue_lon')
    venue_lat = request.args.get('venue_lat')
    venue_timezone = request.args.get('venue_timezone')

    select = "select * from venue v inner join venue_type_has_venue a on a.venue_id=v.venue_id inner join venue_type k on a.venue_type_id=k.type_id where v.venue_address= %s"
    cursor = connection.cursor(dictionary=True)
    cursor.execute(select, (address,))
    resultat = cursor.fetchall()
    return json.dumps(resultat)

@app.route('/add/venue/<address>')
def add_venue(address=str):
    connection = connect_db()
    venue_name = request.args.get('venue_name')
    venue_lon = request.args.get('venue_lon')
    venue_lat = request.args.get('venue_lat')
    venue_timezone = request.args.get('venue_timezone')
    select = "INSERT INTO venue (venue_address, venue_name, venue_lon, venue_lat, venue_timezone) " \
             "VALUES (%s, %s, %s, %s, %s)"
    cursor = connection.cursor(dictionary=True)
    cursor.execute(select, (address, venue_name, venue_lon, venue_lat, venue_timezone))
    connection.commit()
    select = "select MAX(venue_id) as venue_id from venue"
    cursor.execute(select)
    resultat = cursor.fetchone()
    return resultat

@app.route('/add/hours_analysis/<venue_id>')
def add_hours_analysis(venue_id=int):
    connection = connect_db()
    hour = request.args.get('hour')
    day_row = request.args.get('day_row')
    intensity_txt = request.args.get('intensity_txt')
    day_int = request.args.get('day_int')
    select = "INSERT INTO hours_analysis (venue_id, hour, day_row, intensity_txt, day_int) " \
             "VALUES (%s, %s, %s, %s, %s)"
    cursor = connection.cursor(dictionary=True)
    cursor.execute(select, (venue_id, hour, day_row, intensity_txt, day_int))
    connection.commit()
    return "OK"

@app.route('/add/venue_type/<venue_id>')
def add_venue_type(venue_id=int):
    global type_id
    connection = connect_db()
    venue_tag = request.args.get('venue_tag')
    select_tag = "Select type_id From venue_type where venue_tag=%s"
    cursor = connection.cursor(dictionary=True)
    cursor.execute(select_tag, (venue_tag,))
    resultat = cursor.fetchone()
    if resultat is None:
        select = "INSERT INTO venue_type (venue_tag) VALUES (%s)"
        cursor = connection.cursor(dictionary=True)
        cursor.execute(select, (venue_tag,))
        connection.commit()
        select = "SELECT MAX(type_id) as type_id from venue_type"
        cursor.execute(select)
        resultat2 = json.dumps(cursor.fetchall())
        type_id = resultat2[12:].replace("}", "").replace("]", "")
        select = "INSERT INTO venue_type_has_venue (venue_type_id, venue_id) VALUES (%s, %s)"
        cursor = connection.cursor(dictionary=True)
        cursor.execute(select, (type_id, venue_id))
        connection.commit()
        return "OK"+type_id
    else:
        resultat2 = json.dumps(resultat)
        type_id = resultat2[12:].replace("}", "").replace("]", "")
        select = "INSERT INTO venue_type_has_venue (venue_type_id, venue_id) VALUES (%s, %s)"
        cursor = connection.cursor(dictionary=True)
        cursor.execute(select, (type_id, venue_id))
        connection.commit()
        return "OK"


if __name__ == '__main__':
    app.run(host='0.0.0.0', debug=True, port=5000)