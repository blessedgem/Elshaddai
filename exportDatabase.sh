ssh cloudera@10.76.254.127 'sqoop import-all-tables --connect 'jdbc:mysql://10.76.254.50:3306/Sales' --username=cloudera --password= ' &> exportDatabse.out