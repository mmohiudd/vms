#!/bin/bash
rm -f /etc/udev/rules.d/70-persistent-net.rules
rm -f /etc/sysconfig/network-scripts/ifcfg-eth1
/etc/init.d/network restart

# write to hosts 
echo "192.168.100.22	master1.localhost" >> /etc/hosts
echo "192.168.100.23	slave1.localhost" >> /etc/hosts
echo "192.168.100.24	slave2.localhost" >> /etc/hosts