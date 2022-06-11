#!/bin/sh
cd ../../../zncore/base/bin
php zn db:migrate:generate

#use --withConfirm=0 for skip dialog
