# Installation
### Add IP alias, on your host machine, for enable Xdebug
1. `sudo ifconfig lo0 alias 10.254.254.254 netmask 255.255.255.0`
1. `git submodule init`
1. `git submodule update`
1. `docker-compose up -d --remove-orphans --force-recreate --build`
