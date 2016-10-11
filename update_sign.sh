#!/bin/bash


new_slideshow="$1 $2 $3 $4 $5 $6 $7 $8 $9"
echo "Script executed the slideshow $new_slideshow"
echo

what_to_grep="test_script"
current_running_pid="ps faux |grep $what_to_grep |grep -v grep|awk '{print \$2}'"
pid_to_kill=$(eval $current_running_pid)
current=$(eval $current_running_pid)
#echo $pid_to_kill
#echo $pid_to_kill

if [ $pid_to_kill ]
  then
  #echo "PID to kill = $pid_to_kill"
  sleep 2
  kill $pid_to_kill

  for i in $(echo $pid_to_kill)
    do kill $i
    echo 'PID $i was killed'
  done
  echo "PID $pid_to_kill was killed"

fi

if [ ! $pid_to_kill ]
  then
    echo "No Currently running PID"
fi

if [ -n $new_slideshow]
  then
    #Command to start new slide
    nohup ./$new_slideshow &>/dev/null & disown
    sleep 1
    new_pid=$(eval $current_running_pid)
    echo "slidshow $new_slideshow started with PID $new_pid"
fi

