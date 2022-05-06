#!/bin/sh
cd ../../../bin
php zn db:migrate:down

#use --withConfirm=0 for skip dialog
