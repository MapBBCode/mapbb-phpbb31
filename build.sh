#!/bin/sh
DISTFILE=mapbbcode-latest.zip
LIB_PATH=zverik/mapbbcode/styles/all/theme
wget -nv http://mapbbcode.org/dist/$DISTFILE
unzip -q $DISTFILE
rm $DISTFILE
mkdir -p $LIB_PATH
mv mapbbcode $LIB_PATH/

TARGET=dist/mapbbcode_ext.zip
zip -qr $TARGET zverik
rm -r $LIB_PATH/mapbbcode
