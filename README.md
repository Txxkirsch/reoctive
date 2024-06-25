# Description

Reoctive is a small tool based on CakePHP5 to help you automate your Reolink devices
via HTTP-Requests or cli commands.

E.g. you can setup your smartphone to call the api when you enter/leave
a specific WiFi in order to deactivate/active push alarms.
So you wont get notifications when you are at home.

Reoctive is aimed to people which have some experience in programming and networking.

If you want to call the api from outside of your network you may need a dynamic dns service.

# Installation

You will need a database in order to queue the events.
Mysql/Mariadb or sqlite work fine.
Just configure it in your config/app_local.php and run the migrations.

```
git clone https://github.com/txxkirsch/reoctive
composer install
cp config/app_local.example.php config/app_local.php
cp config/.env.example config/.env
```

You can check your installation via http(s)://\<your-host-domain\>/reoctive/?pw=<your-api-password>

# Setup

nano config/app_local.php

edit Datasources.default

nano config/.env

set your values

If you set an API_PASSWORD you will need to append it to every api-call as query-param (?pw=)

crontab -e
```
*/5 * * * * cd /<path>/<to>/<your>/reoctive && bin/cake queue run -q
```

```
bin/cake migrations migrate -p Queue
```

# Device management

list devices via command
```
bin/cake ListDevices
```

adding device via command
```
bin/cake AddDevice
```

deleting device via command
```
bin/cake RemoveDevice
```

# Configure Events

Configure your events in src/Event/ReolinkListener.php

## Preconfigured/Example Events

activate: Enables email and push notifications on all configured devices
deactivate: Disables email and push notifications on all configured devices

# Tasks

Adding new Tasks
```
bin/cake bake queue_task <Name>
```

# Usage

HTTP-Get to http(s)://<your-host-domain>/reoctive/api/event/<event-name>?pw=<your-api-password>

e.g. https://example.com/reoctive/api/event/activate?pw=reopassword

When the endpoint gets called it will queue a task in the database.
A queue worker will pick up the task a few seconds later and execute it.

# Sources

 - Reolink API Documentation
 https://community.reolink.com/topic/4196/reolink-camera-api-user-guide_v8-updated-in-april-2023
 
 - CakePHP Documentation
 https://book.cakephp.org/5/en/index.html

# ToDo

simplify installation/initial configuration

