#!/bin/bash

mp4='.mp4'
flv='.flv'
webm='.webm'
success='.success'
failed='.failed'

ffmpeg -i $1 -y -acodec libvorbis -aq 5 -ac 2 -qmax 25 -threads 6 $2$webm >> $3 2>&1
return=$?
if [ $return -eq 0 ];then
   touch $2$webm$success
else
   touch $2$webm$failed
fi