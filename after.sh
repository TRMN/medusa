#!/bin/sh

# If you would like to do some extra provisioning you may
# add any commands you wish to this file and they will
# be run after the Homestead machine is provisioned.
#
# If you have user-specific configurations you would like
# to apply, you may also create user-customizations.sh,
# which will be run after this script.
echo " " >> /home/vagrant/.bashrc
echo "function refresh_mongo() { " >> /home/vagrant/.bashrc
echo "\tmongodump --host=rs0/66.228.33.171 --username=trmn --password=\$1 --db=trmn --archive | mongorestore --archive --drop --db=trmn" >> /home/vagrant/.bashrc
echo "}" >> /home/vagrant/.bashrc
