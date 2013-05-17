#!/bin/bash
rm -f /etc/udev/rules.d/70-persistent-net.rules
rm -f /etc/sysconfig/network-scripts/ifcfg-eth1
/etc/init.d/network restart

# remove existig entry, if any
sed -i '/'master1.localhost'$/ d' /etc/hosts
# add a new one
echo "192.168.100.22	master1.localhost" >> /etc/hosts


sed -i '/'slave1.localhost'$/ d' /etc/hosts
echo "192.168.100.23	slave1.localhost" >> /etc/hosts

sed -i '/'slave2.localhost'$/ d' /etc/hosts
echo "192.168.100.24	slave2.localhost" >> /etc/hosts
