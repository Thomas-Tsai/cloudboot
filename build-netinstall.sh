#!/bin/bash
[-d netinstall] || mkdir -p netinstall_img
/opt/drbl/sbin/drbl-netinstall -d netinstall_img/ -i all -s -w
