#!/bin/bash

ssh cloudera@10.76.254.127 "sqoop import --connect 'jdbc:postgresql://10.76.254.50:5432/Project' --username=postgres --password=gem --target-dir /newfolder7 --fields-terminated-by '\t' --table account_transactions -m 1" &> export.out
