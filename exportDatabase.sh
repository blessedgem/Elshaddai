#!/bin/bash

ssh cloudera@$vitualhost "sqoop import-all-tables --connect 'jdbc:$databasetype://$localhost:$portnumber/$databasename' --username=$username --password=$password --warehouse-dir=/user/hive/warehouse  --hive-import -m 1" &> exportDatabse.out
