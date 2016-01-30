#!/bin/bash

curl "http://localhost/v1/ajax/torrent/utorr/pauseFinished.php" >> /home/flipsorry/cron/logs/pausedTorrents.txt
exit
