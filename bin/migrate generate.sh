#!/bin/sh
cd ../../../znlib/console/bin
php zn db:migrate:generate

#use --withConfirm=0 for skip dialog
