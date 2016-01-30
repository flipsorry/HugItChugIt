#!/bin/bash

files=/home/flipsorry/cron/runjob/*

for file in $files
do
  echo "Processing $file file..."
  # take action on each file. $f store current file name
  inputFile=`cat $file | jq --raw-output '.inputFile'`
  outputFile=`cat $file | jq --raw-output '.outputFile'`
  logFile=`cat $file | jq --raw-output '.logFile'`
  additionalArgs=`cat $file | jq --raw-output '.additionalArgs'`
  echo "inputFile: $inputFile"
  echo "outputFile: $outputFile"
  echo "additionalArgs: $additionalArgs"
  echo "logFile: $logFile"
  rm "$file"
  #inputFile="/home/flipsorry/Dos/Torrents/Sicario/Sicario (2015).mkv"
  #echo $inputFile
  #ls $inputFile
  avconv -y -i "$inputFile" -vcodec copy -acodec aac -strict experimental "$outputFile" 2> $logFile
  #$command
done

exit
