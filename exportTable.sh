ssh cloudera@ 'sqoop import --connect 
            'jdbc:postgresql://:5432/dummy' --username=postgres --password=gem 
            --target-dir / --table dummy_table -m 1 --warehouse-dir=/user/hive/warehouse -hive-import'
             &> exportTable.out