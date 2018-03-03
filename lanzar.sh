#!/bin/bash
FILES_BUSQ="$2"
FILES_CATS="$1"
PYTHON_PATH="$3"
DB_HOST=$4
DB_DB=$5
DB_USER=$6
DB_PWD=$7
FILE_DESTINOS=$8
CODEC=$9


$3 ./cargarConsultas.py $DB_HOST $DB_DB $DB_USER $DB_PWD $FILES_CATS $CODEC
$3 ./cargarDestinos.py $DB_HOST $DB_DB $DB_USER $DB_PWD $FILE_DESTINOS


for f in $FILES_BUSQ/*.csv
do
  echo "Processing $f file..."
  dos2unix $f
  $3 ./cargarBusquedas.py $DB_HOST $DB_DB $DB_USER $DB_PWD $f

done



