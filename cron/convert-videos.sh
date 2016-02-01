#!/bin/bash

jobs=`mysql --user=root --password=liemdinh Torrents --silent --skip-column-names -e "SELECT Title, InputFile, OutputFile, LogFile, Type, AdditionalArgs FROM ConvertVideo WHERE Status = 'ENQUEUE' LIMIT 1;"`

IFS=$'\n'
for job in $jobs
do
  #echo "JOBS: $job"
  title=`echo "$job" | awk -F'\t' '{print $1}'`
  inputFile=`echo "$job" | awk -F'\t' '{print $2}'`
  outputFile=`echo "$job" | awk -F'\t' '{print $3}'`
  logFile=`echo "$job" | awk -F'\t' '{print $4}'`
  fileType=`echo "$job" | awk -F'\t' '{print $5}'`
  additionalArgs=`echo "$job" | awk -F'\t' '{print $6}'`
  #outputFile=`cat $file | jq --raw-output '.outputFile'`
  #logFile=`cat $file | jq --raw-output '.logFile'`
  #additionalArgs=`cat $file | jq --raw-output '.additionalArgs'`
  echo "title: $title"
  echo "inputFile: $inputFile"
  echo "outputFile: $outputFile"
  echo "additionalArgs: $additionalArgs"
  echo "logFile: $logFile"
  echo "fileType: $fileType"
  audioStreamIndex=`echo "$additionalArgs" | jq --raw-output '.audioStreamIndex'`
  vCopy="libx264"
  if [ "$fileType" == "mkv" ]; then
    vCopy="copy"
  fi
  echo "vCopy: $vCopy"
  mysql --user=root --password=liemdinh Torrents -e "UPDATE ConvertVideo Set Status = 'CONVERTING' WHERE Title ='$title'"
  avconv -y -i "$inputFile" -map 0:0 -map 0:$audioStreamIndex -vcodec $vCopy -acodec aac -strict experimental "$outputFile" 2> $logFile
  mv "$inputFile" "/home/flipsorry/Dos/OldTorrents/$title"
  mysql --user=root --password=liemdinh Torrents -e "UPDATE ConvertVideo Set Status = 'DONE' WHERE Title ='$title'"

done

#files=/home/flipsorry/cron/runjob/*

#for file in $files
#do
  #echo "Processing $file file..."
  # take action on each file. $f store current file name
  #inputFile=`cat $file | jq --raw-output '.inputFile'`
  #outputFile=`cat $file | jq --raw-output '.outputFile'`
  #logFile=`cat $file | jq --raw-output '.logFile'`
  #additionalArgs=`cat $file | jq --raw-output '.additionalArgs'`
  #echo "inputFile: $inputFile"
  #echo "outputFile: $outputFile"
  #echo "additionalArgs: $additionalArgs"
  #echo "logFile: $logFile"
  #rm "$file"
  #inputFile="/home/flipsorry/Dos/Torrents/Sicario/Sicario (2015).mkv"
  #echo $inputFile
  #ls $inputFile
  #avconv -y -i "$inputFile" -vcodec copy -acodec aac -strict experimental "$outputFile" 2> $logFile
  #$command
#done

exit
