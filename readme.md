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


### 2. Add Slack Media Type to admin user


### 3. Add new Action


