ssh cloudera@10.76.254.127 'sqoop import-all-tables --connect 'jdbc:postgresql://localhost:5432/dummy' --username=postgres --password=gem ' &> ImportTable.out