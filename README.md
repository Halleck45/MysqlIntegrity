Mysql Integrity Checker
===============

Allows to check (and repairs) Foreign Key's errors in MySQL databases

Usage:

    php integrity.php 
        --name=dbname               name of the database
        
        --user=username             mysql user
        --password=abc123           mysql password
        --host=localhost            host
        --action=list|clean         expected behavior (default:list)
                                    list: list all failures
                                    clean: remove failures
