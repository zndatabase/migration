#!/bin/sh
cd ../../../zncore/base/bin
php zn db:migrate:down

#use --withConfirm=0 for skip dialog
