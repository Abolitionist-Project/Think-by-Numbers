#!/bin/sh

SQL_FILE="$(dirname "$0")/../setup_test_database.sql"

echo -n "Generating ${SQL_FILE}..."
echo "DROP USER 'quantimodo'@'localhost';"> "$SQL_FILE"
echo "CREATE USER 'quantimodo'@'localhost' IDENTIFIED BY 'PDNZCF7bv7CDX5D6';">> "$SQL_FILE"
echo>> "$SQL_FILE"
echo "GRANT ALL ON \`quantimodo\`.* TO 'quantimodo'@'localhost';">> "$SQL_FILE"
mysqldump -uroot --databases quantimodo --add-drop-database>> "$SQL_FILE"
echo "done."
echo
