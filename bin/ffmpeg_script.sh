#!/bin/bash

mp4='.mp4'
flv='.flv'
webm='.webm'

ffmpeg -y -i $1 -vcodec libx264 -acodec libfaac -profile:v baseline -level 3.0 $2$mp4 > test.txt 2>&1
ffmpeg -i $1  -y -vcodec libvpx -acodec libvorbis $2$webm >> test.txt 2>&1
ffmpeg -i $1  -y -vcodec flv -acodec libmp3lame $2$flv >> test.txt 2>&1