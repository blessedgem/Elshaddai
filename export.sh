#!/bin/bash

ssh cloudera@192.168.43.93 "sqoop import --connect 'jdbc:postgresql://192.168.43.43:5432/Project' --username=postgres --password=gem --target-dir /newfolder1 --fields-terminated-by '\t' --table account_transactions -m 1" &> export.out
