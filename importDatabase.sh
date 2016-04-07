#!/bin/bash

ssh cloudera@$virtualhost "sqoop export-all-tables --connect 'jdbc:$databasetype://$localhost:$portnumber/$databasename' --username=$username --password=$password --warehouse-dir=/user/hive/warehouse --hive-import  -m 1" &> import.out
