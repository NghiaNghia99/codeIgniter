#!/bin/bash

mp4='.mp4'
success='.success'
failed='.failed'

ffmpeg -y -i $1 -vcodec libx264 -acodec copy -preset veryslow -movflags +faststart -pix_fmt yuv420p -profile:v baseline -level 3.0 -threads 6 -g 1 $2$mp4 > $3 2>&1 
return=$?
if [ $return -eq 0 ];then
   touch $2$mp4$success
else
   touch $2$mp4$failed
fi
