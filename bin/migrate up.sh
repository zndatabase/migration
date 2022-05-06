#!/bin/sh
cd ../../../bin
php zn db:migrate:up

#use --withConfirm=0 for skip dialog
