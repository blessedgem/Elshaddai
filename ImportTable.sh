ssh cloudera@10.76.254.127 "sqoop export --connect 
            'jdbc:postgresql://10.76.254.50:5432/Project' --username=postgres 
        --password=gem --export-dir=/user/hive/warehouse/dummy_table  --input-fields-terminated-by '\t' --table dummy_table -m 1 " &> ImportTable.out