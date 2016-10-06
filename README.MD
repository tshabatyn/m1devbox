# Installation
### Add IP alias, on your host machine, for enable Xdebug
1. `sudo ifconfig lo0 alias 10.254.254.254 netmask 255.255.255.0`
1. `git submodule init`
1. `git submodule update`
1. `docker-compose up -d -f env/docker-compose.yml --remove-orphans --force-recreate --build`

# Available tools
### Profiling PHP code
To enable profiler you have to add GET parameter `profile=1`. You have to do it once.
After first request it will create cookie, all the further requests will be profiled.

For accessing xhgui add the following line to your hosts:

`127.0.0.1 xhgui.local`

After this you can see all the profiles by the [link](http://xhgui.local/).

To disable profiler you have to add GET parameter `profile=0`. It will unset cookie.
After this profiler will be disabled, for all the further requests.
