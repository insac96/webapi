#!/bin/bash
HOSTNAME="localhost"
PORT="3306"
USERNAME="root"
PASSWORD="root"
API="API"

mysql -h$HOSTNAME -P$PORT -u$USERNAME -p$PASSWORD -e "create database $API DEFAULT CHARACTER SET utf8;"
mysql -u$USERNAME -p$PASSWORD $API < api.sql
