# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure("2") do |config|
  config.vm.box = "CentOS6.3"
  
  config.vm.box_url = "http://packages.vstone.eu/vagrant-boxes/centos/6.3/centos-6.3-64bit-puppet.3.x-vbox.4.2.6.box"
  # there are many others here http://packages.vstone.eu/vagrant-boxes/centos/6.3/

  config.vm.provision :shell, :path => "provision/shell/network.sh" # fix all network related things
  config.vm.provision :shell, :path => "provision/shell/php.sh" # install php cli
  
  config.vm.define :master1 do |master1|
    master1.vm.network :forwarded_port, guest: 22, host: 22221
    master1.vm.hostname = "master1.localhost"
    master1.vm.network :private_network, ip: "192.168.100.22"
    master1.vm.synced_folder "code/master", "/home/vagrant/code"
  end

  config.vm.define :slave1 do |slave1|
    slave1.vm.network :forwarded_port, guest: 22, host: 22223
    slave1.vm.hostname = "slave1.localhost"
    slave1.vm.network :private_network, ip: "192.168.100.23"
    slave1.vm.synced_folder "code/slave", "/home/vagrant/code"
  end

  config.vm.define :slave2 do |slave2|
    slave2.vm.network :forwarded_port, guest: 22, host: 22224
    slave2.vm.hostname = "slave2.localhost"
    slave2.vm.network :private_network, ip: "192.168.100.24"
    slave2.vm.synced_folder "code/slave", "/home/vagrant/code"
  end
end
