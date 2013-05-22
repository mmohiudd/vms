vms
===

A vagrant based multi-machine development environment. This is simply a collection of some scripts for awesome tools.

I am using [multi-machine](http://docs.vagrantup.com/v2/multi-machine/index.html) to deploy connected machines. Each machine has a [synced folders](http://docs.vagrantup.com/v2/synced-folders/index.html) called `code`. The `code/slave` and `code/master` folders are synced to `/home/vagrant/code`. 

Accessing code in machines becomes really easy that way. 


### General Requirements
* [Vagrant 1.2.1](http://www.vagrantup.com/)
* [Capistrano 2.15.4](https://github.com/capistrano/capistrano) - only if you want to work smart, not hard. 
 

### What can improve
Currently I am using a shell provisioner. Plan is to move to a puppet soon. The [box](http://packages.vstone.eu/vagrant-boxes/centos/6.3/) I am using has [Puppet 3.0.2](https://projects.puppetlabs.com/versions/337) installed. 
 

### How to change things
* OS: change the box information from the `Vagrant` file.
* Add more machines: add more machines from the `Vagrant` file.
 
### Example
```

# this will up all machine(s)
vagrant up

# this will invoke all daemon.php script(s) 
cap start_daemon


# check out what is happening in sockets
cap view_log

```


 
 

