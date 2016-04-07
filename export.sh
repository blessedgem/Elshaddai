#!/bin/bash

ssh cloudera@$virtualhost "sqoop import --connect 'jdbc:postgresql://$localhost:5432/$databasename' --username=postgres --password=gem --warehouse-dir=/user/hive/warehouse --fields-terminated-by '\t' --table $tablename --hive-import -m 1" &> export.out
