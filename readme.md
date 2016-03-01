# Slack notification script for Zabbix

[![Build Status](https://travis-ci.org/shin1x1/zabbix-slack-notification.svg?branch=master)](https://travis-ci.org/shin1x1/zabbix-slack-notification)

## About

`slack.php` is the Zabbix action script that send notification to Slack.This script written by PHP (requires PHP 5.3 or above and PHP 7.0).

### Versions

This works with Zabbix 2.2 or above.(I tested on Zabbix 2.2.)

## Installation

First, you check `AlertScriptsPath` setting. It is specified within the Zabbix Server configuration file(located `/etc/zabbix/zabbix_server.conf` if zabbix installed by yum.)

```
$ sudo grep AlertScriptsPath /etc/zabbix/zabbix_server.conf
### Option: AlertScriptsPath
# AlertScriptsPath=${datadir}/zabbix/alertscripts
AlertScriptsPath=/usr/lib/zabbix/alertscripts
```

Second, you download `slack.php` to `AlertScriptPath` and add execution permission to the script.

```
$ cd /usr/local/etc/zabbix/
$ sudo wget https://raw.githubusercontent.com/shin1x1/zabbix-slack-notification/master/slack.php
$ sudo chmod a+x slack.php
```

Third, you configure some settings. Slack incoming webhook url could create at https://my.slack.com/services/new/incoming-webhook .

```
$ sudo vim slack.php
#!/usr/bin/env php
<?php
$SLACK_URL = ''; // your slack incoming webhook url
$ZABBIX_URL = 'https://example.com/zabbix/'; // (optional) your zabbix web front url
```

## Configuration on Zabbix web frontend

### 1. Add new Media Type

[Administration] - [Media Types] - [Create media type]

<img width="276" alt="configuration_of_media_types" src="https://cloud.githubusercontent.com/assets/88324/13426525/43c3b328-dff1-11e5-95b1-f7ac1a3175c0.png">

### 2. Add Slack Media Type to admin user

[Administration] - [Users]

* `Send to` - Slack channel

<img width="275" alt="configuration_of_users" src="https://cloud.githubusercontent.com/assets/88324/13426530/55e84078-dff1-11e5-89d7-9856dce4ca06.png">

<img width="201" alt="media" src="https://cloud.githubusercontent.com/assets/88324/13426479/f3f015da-dff0-11e5-9348-e7a1e92c29fb.png">

### 3. Add new Action

[Configuration] - [Actions] - [Create action]

<img width="278" alt="configuration_of_actions - action" src="https://cloud.githubusercontent.com/assets/88324/13426576/a7cbdab2-dff1-11e5-94a0-1137dd0ab361.png">

<img width="277" alt="configuration_of_actions - conditions" src="https://cloud.githubusercontent.com/assets/88324/13426584/b330816e-dff1-11e5-8194-f9ae553bc91b.png">

<img width="441" alt="configuration_of_actions_-_operations" src="https://cloud.githubusercontent.com/assets/88324/13426589/bc092c46-dff1-11e5-858b-47aab29a1304.png">

<img width="430" alt="configuration_of_actions_-_edit-operation" src="https://cloud.githubusercontent.com/assets/88324/13426602/d13c337e-dff1-11e5-9b69-e063d1d9b774.png">


