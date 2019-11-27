#!/bin/bash

check_process() {
  [ `pgrep -nx ffmpeg` ] && return 1 || return 0
}

while [ 1 ] ; do
	ts=`date +%T`

	echo "$ts: begin checking if ffmpeg is running..."
	check_process 
	[ $? -eq 0 ] && echo "Checking if videos are queued...." && `php /srv/www/vhosts/science-media.org/entwicklung.science-media.org/videoConversion.php`
	sleep 60
done