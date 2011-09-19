#!/bin/bash
set -e

###################################################
# prepare_from_free.sh
# 	Description: Prepare necesssary iso file from free.nchc.org.tw and extra them into kernel 
# Last update :
# Author:
#	Ceasar Sun <ceasar_at_nchc_org_tw>
#	Thomas Tsai <thomas_at_nchc_org_tw>
#
#	Free Software Lab, NCHC, Taiwan
# License: GPL
####################################################
export PATH=$PATH:/usr/sbin:/bin:/sbin:/sbin

cloudboot_root_path=$(cd $(dirname $0) ;pwd)

# Load sub function for global usage
[ -f "$cloudboot_root_path/functions.lib" ] &&  . $cloudboot_root_path/functions.lib

_local_iso_pool="iso_img"
_local_kernel_pool="kernel_img"

_iso_source_site="http://free.nchc.org.tw"
#_iso_release_branch="/clonezilla-live/stable"
_iso_release_branch="/clonezilla-live/stable /clonezilla-live/testing /clonezilla-live/alternative/stable /clonezilla-live/alternative/testing /drbl-live/stable /drbl-live/testing /gparted-live/stable /gparted-live/testing"

_VERBOSE=

#######
# Main
#######

while [ $# -gt 0 ]; do
	case "$1" in
		-v|--verbose) shift ; _VERBOSE="-v" ;;
	esac
done


pushd $cloudboot_root_path

# Stage 1: get iso file form 
# tmp_iso_pool=`mktemp -dt iso.build.XXXXXX`
#[ -d "$cloudboot_root_path/$_local_iso_pool" ] && rsync -av $cloudboot_root_path/$_local_iso_pool/ $tmp_iso_pool/
pushd $cloudboot_root_path/$_local_iso_pool

for _release_id in $_iso_release_branch ; do
	[ -d "$cloudboot_root_path/$_local_iso_pool/$_release_id" ] || mkdir -p $cloudboot_root_path/$_local_iso_pool/$_release_id
	lftp -e "o $_iso_source_site/$_release_id/ && lcd $cloudboot_root_path/$_local_iso_pool/$_release_id/ && mirror  -r -e --include '.iso'  && quit"
done

# rebuild soft link for iso
rm *.iso 2>/dev/null ; find . -name *.iso -exec ln -s {} \;
popd
# end of stage 1

# Stage 2 : extra kernel, initrd.img, filesystem.squashfs from iso
_comm_7z=`which 7z 2>/dev/null | head -n1`
[ -z $_comm_7z ] && echo "$0: 7z not found, please install or set into \$PATH" && exit 1;

[ -d "$cloudboot_root_path/$_local_kernel_pool" ] || mkdir -p $cloudboot_root_path/$_local_kernel_pool

pushd $cloudboot_root_path/$_local_kernel_pool
rm $_VERBOSE -rf $cloudboot_root_path/$_local_kernel_pool/*		# poor !!!!! It needs to be enhanced , by Ceasar

tmp_iso_extra=`mktemp -dt iso.extra.XXXXXX`
for iso_file in `find $cloudboot_root_path/$_local_iso_pool -name *.iso` ; do
	rm -rf $tmp_iso_extra/*
	iso_name="$(basename $iso_file)"
	iso_bname="${iso_name%.*}"

	$_comm_7z -y x $iso_file -o$tmp_iso_extra
	kernel_for_this="$(find $tmp_iso_extra -name vmlinuz 2>/dev/null)"
	initrd_for_this="$(find $tmp_iso_extra -name initrd.img 2>/dev/null)"
	squashfs_for_this="$(find $tmp_iso_extra -name filesystem.squashfs 2>/dev/null)"

	if [ -n "$kernel_for_this" -a -n "$initrd_for_this"  -a -n "$squashfs_for_this" ]; then
		mv $_VERBOSE $kernel_for_this $cloudboot_root_path/$_local_kernel_pool/$iso_bname.vmlinuz
		mv $_VERBOSE $initrd_for_this $cloudboot_root_path/$_local_kernel_pool/$iso_bname.initrd.img
		mv $_VERBOSE $squashfs_for_this $cloudboot_root_path/$_local_kernel_pool/$iso_bname.filesystem.squashfs
	else 
		 $SETCOLOR_WARNING; echo "Error during extracting $iso_name ?? " ; $SETCOLOR_NORMAL
	fi
	
done

rm -rf $tmp_iso_extra
popd
# end of stage 2

popd
exit 0;




