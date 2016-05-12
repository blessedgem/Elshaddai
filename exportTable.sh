ssh cloudera@10.76.254.127
         "sqoop import --connect 'jdbc:postgresql://10.76.254.50:5432/dummy' 
         --username=postgres --password=gem --target-dir --table dummy_table -m 1 
         --warehouse-dir=/user/hive/warehouse/holy  --hive-import"
         &> exportTable.out