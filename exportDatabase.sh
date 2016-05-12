ssh cloudera@10.76.254.127 
        	'sqoop import-all-tables --connect 'jdbc:postgresql:
        	//10.76.254.50:5432/
        	Project' --username=postgres 
        	--password=gem --warehouse-dir=/user/hive/warehouse --hive-import'
        	 &> exportDatabse.out