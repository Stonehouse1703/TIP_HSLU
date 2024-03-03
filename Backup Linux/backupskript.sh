# Name: backup.sh
# Erstellungsdatum: 07.01.2024
# Version: 1.0
# Autor: Colin Felber
# Funktion: Dieses Skript fuehrt Full Backups oder Incremental Backups durch. Dabei wird zuerst ueberprueft, ob auf dem Speichermedium bereits Backups durchgefuehrt wurden. 
#           Falls nicht, wird dort eine Datenstruktur angelegt. Dabei wird sofort ein "Full Backup" durchgefuert.


#!/bin/bash


#-------------------------------------------< Parameter >-------------------------------------------------------------------------

# Parameter abfrage
speicherverzeichnis=$1
ortausputdatei=$2
artbackup=$3
anzahl_zu_behaltende_backups=$4

# Fuer den Speichername
datum=$(date +'DATE_%d_%m_%Y__TIME_%H_%M_%S')
archiv_ordername="${datum}_backup"

# Fuer die Pfade
quelle="/home"
hauptordnername="backups"
fullbackupname="fullbackups"
fullbackup_pfad="$speicherverzeichnis/$hauptordnername/$fullbackupname"
fullbackup_pfad_speichern="$fullbackup_pfad/$archiv_ordername"
incrementalbackup_pfad="$speicherverzeichnis/$hauptordnername"
snapshot="$incrementalbackup_pfad/latest.snapshot"

#-------------------------------------------< Funktionene >-------------------------------------------------------------------------
erstelle_backup_zip(){
	zip -rq "$fullbackup_pfad_speichern.zip" /home/* --exclude \*.cache\*

	if [ $? -eq 0 ]; then
		txt_in_Datei "$datum: Fullbackup Backup wurde durchgefuehrt. Dabei wurde die Datei $archiv_ordername genannt" "$speicherverzeichnis/$hauptordnername/Informationen.tmp"
		txt_in_Datei "$datum: Fullbackup Backup wurde durchgefuehrt. Dabei wurde die Datei $archiv_ordername genannt" "$ortausputdatei"
	else 
		txt_in_Datei "$datum: ZIP-Datei konnte nicht erstellt werden." "$ortausputdatei"
		exit 1
	fi
}
	
txt_in_Datei(){
	txt="$1"
	Datei_pfad="$2"
	echo $txt >> $Datei_pfad
}

#-------------------------------------------< Hauptcode >-------------------------------------------------------------------------

# Falls keine Parameter eingegeben werden, wird angezeigt, welche Parameter eingegeben werden muessen.
if [ "$1" = "--help" ] || [ "$#" -lt 3 ]; then
	echo "Dieses Skript macht full Backups und incremental Backups. Dabei gibt es folgende Parameter:
sudo ./backups.sh /max/muster /max/muster/ 0 5
|      |            |       	 |  	   | |- (nur bei full Backups) gewuenschte Anzahl von full Backups, 0 = keine Einschrenkung
|      |            |       	 |	   |--- 0 = full Backup
|      |            |       	 |	   |--- 1 = incremental Backup
|      |	    |            |------------- Pfad zur Dokumentation der Backups
|      |            |-------------------------- Pfad vom Speichermedium
|      |--------------------------------------- ausfuehrung vom Skript
|---------------------------------------------- Fuer den manuell Modus, braucht es sudo, sodass alle Users gespeichert werden koennen"
	if [ -n "$3" ]; then
		txt_in_Datei "Positionsparameter stimmen nicht" >> "$ortausputdatei"
	fi
	exit 1
fi

# ueberpruefen, ob keine Parameter eingegeben wurden
if [ "$artbackup" -eq 0 ] || [ "$anzahl_zu_behaltende_backups" -lt 0 ]; then
	echo "Es ist nicht moeglich $anzahl_zu_behaltende_backups Backups zu erstellen"
	txt_in_Datei "Es ist nicht moeglich $anzahl_zu_behaltende_backups Backups zu erstellen" "$ortausputdatei"
	exit 1
fi

# ueberpruefung, ob das Speicherverzeichnis vorhanden ist
if [ ! -d "$speicherverzeichnis" ]; then
	echo "Speichermedium nicht vorhanden."
	txt_in_Datei "Speichermedium nicht vorhanden." "$ortausputdatei"
	exit 2
fi


# Es wird ueberprueft, ob das Speichermedium bereits verwendet wurde, indem geprueft wird, ob der Ordner 'Backup' vorhanden ist.
# Falls nicht, wird die Dateistruktur erstellt und sowohl ein Full Backup als auch ein Incremental Backup erzeugt.
if [ ! -d "$speicherverzeichnis/$hauptordnername" ]; then
	echo "Das Speichermedium wurde noch nie verwendet. Daher wird eine Dateistruktur angelegt & direkt Backups erstellt. Dieser Vorgang kann mehrere Minuten dauern."
	mkdir -p "$speicherverzeichnis/$hauptordnername/$fullbackupname"   
	erstelle_backup_zip

# Wenn die Dateistruktur vorhanden ist und der Parameter auf 0 gesetzt wurde, wird ein Fullbackup erstellt.
# Dabei wird ueberprueft, wie viele ZIP-Dateien bereits vorhanden sind.
# Falls mehr Dateien vorhanden sind, als im Parameter angegeben, werden die aeltesten geloescht.
elif [ -d "$fullbackup_pfad" ] && [ "$artbackup" = 0 ]; then
	while [ "$(find "$fullbackup_pfad" -name "*.zip" | wc -l)" -ge "$anzahl_zu_behaltende_backups" ] && [ "$anzahl_zu_behaltende_backups" -gt "0" ] ; do
		find "$fullbackup_pfad" -name "*.zip" -exec ls -t --time=creation {} + 2>/dev/null | tail -n +"$anzahl_zu_behaltende_backups" | xargs rm -f
		#find "$fullbackup_pfad" -name "*.zip" -exec ls -t --time=creation {} + 2>/dev/null | tail -n +"$anzahl_zu_behaltende_backups" | xargs rm -f
		#find "$fullbackup_pfad" -name "*.zip" -exec ls -t --time=creation {} | tail -n +"$anzahl_zu_behaltende_backups" | xargs rm -f
		echo "Da schon $anzahl_zu_behaltende_backups Backups vorhanden sind, wurden die aeltesten Backups entfernt."
		echo $anzahl_zip_dateien
	done

	erstelle_backup_zip
	echo "Backup erstellt"
fi

# Wenn die Dateistruktur vorhanden ist und im Parameter 1 eingegeben wurde, wird ein Incremental Backup erzeugt.
if [ "$artbackup" = "1" ]; then
	echo "Bitte beachten Sie, dass es einige Minuten dauern kann."
	tar --create --listed-incremental="$snapshot" --file="$incrementalbackup_pfad/backup.tar" "$quelle"
	if [ $? -eq 0 ]; then
		txt_in_Datei "$datum: Incremental Backup wurde durchgefuehrt" "$speicherverzeichnis/$hauptordnername/Informationen.tmp"
		txt_in_Datei "$datum: Incremental Backup wurde durchgefuehrt" "$ortausputdatei" 
		echo "Incremental Backup wurde durchgefuehrt."
	else 
		txt_in_Datei "$datum: Incremental Backup konnte nicht durchgefuehrt werden." "$speicherverzeichnis/$hauptordnername/Informationen.tmp"
		txt_in_Datei "$datum: Incremental Backup konnte nicht durchgefuehrt werden." "$ortausputdatei"
		echo "Incremental Backup konnte nicht durchgefuehrt werden."
		exit 1
	fi
fi
