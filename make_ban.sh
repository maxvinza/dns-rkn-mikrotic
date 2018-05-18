#!/bin/bash 
curl -s https://raw.githubusercontent.com/zapret-info/z-i/master/dump.csv | cut -d ';' -f 1 |  tr '|' '\n' | grep '/' | tr -d ' ' | sort -k1 -n > ban_nets.txt 