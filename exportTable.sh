ssh cloudera@192.168.43.93
         "sqoop import --connect 'jdbc:postgresql://192.168.43.43:5432/dummy' 
         --username=postgres --password=gem --warehouse-dir=/user/hive/warehouse/Graced 
         --table dummy_table --hive-import -m 1 "
         &> exportTable.out