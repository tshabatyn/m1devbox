# Installation

1. #### Link your Magento 1 document root to src
   * `ln -s /path/to/m1/doc/root src`
1. #### Add IP alias, on your host machine, for enable Xdebug
   * `sudo ifconfig lo0 alias 10.254.254.254 netmask 255.255.255.0`
1. #### Init submodules
   * `git submodule init`
   * `git submodule update`
1. #### Create and run containers
   * `docker-compose up -d -f env/docker-compose.yml --remove-orphans --force-recreate --build`

# Available tools

### xhprof + xhgui for profiling PHP code
To enable profiler you have to add GET parameter `profile=1`. You have to do it once.
After first request it will create cookie, all the further requests will be profiled.

For accessing xhgui add the following line to your hosts:

`127.0.0.1 xhgui.local`

After this you can see all the profiles by the [link](http://xhgui.local/).

To disable profiler you have to add GET parameter `profile=0`. It will unset cookie.
After this profiler will be disabled, for all the further requests.

### Xdebug

Please make sure that you didn't miss second step from Installation. Also, there is an issue, you should enable debugger only after containers will up.
