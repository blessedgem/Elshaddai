ssh cloudera@10.76.254.127 "sqoop export --connect 'jdbc:postgresql://localhost:5432/Project' --username=postgres --password=gem --warehouse-dir=/user/hive/warehouse --table   -m 1 " &> importTable.out