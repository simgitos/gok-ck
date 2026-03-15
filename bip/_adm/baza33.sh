#!/bin/sh
#
# Skrypy automatycznej kopii wskazanej bazy MySQL
#
# parametry do po��czenie z baz�

SERVER=localhost
LOGIN=gama_bipgoks
HASLO=bipgok123!@#
BAZA=gama_bipgok


# ILEKOPII - ilo�� przechowywanych kopii
# BACKUPDIR - lokalizacja plik�w kopii zapasowych
ILEKOPII=7
BACKUPDIR=/bazy_mysql

KOPIE=`find $BACKUPDIR -name "$BAZA-*.gz" | wc -l | sed 's/\ //g'`
while [ $KOPIE -ge $ILEKOPII ]
do
ls -tr1 $BACKUPDIR/$BAZA-*.gz | head -n 1 | xargs rm -f
KOPIE=`expr $KOPIE - 1`
done
DATE=`date +%Y%m%d%H%M%S`
rm -f $BACKUPDIR/.$BAZA-${DATE}.gz_TEMP
/usr/syno/mysql/bin/mysqldump --opt -h$SERVER -u$LOGIN -p$HASLO --databases $BAZA | gzip -c -9 > $BACKUPDIR/.$BAZA-${DATE}.gz_TEMP
mv -f $BACKUPDIR/.$BAZA-${DATE}.gz_TEMP $BACKUPDIR/$BAZA-${DATE}.gz
exit 0

