#!/bin/bash

mp4='.mp4'
flv='.flv'
webm='.webm'
success='.success'
failed='.failed'

ffmpeg -y -i $1 -vcodec libx264 -acodec libmp3lame -ar 44100 -f flv -preset veryslow -movflags +faststart -pix_fmt yuv420p -profile:v baseline -level 3.0 -threads 6  $2$flv >> $3 2>&1
return=$?
if [ $return -eq 0 ];then
   touch $2$flv$success
else
   touch $2$flv$failed
fi