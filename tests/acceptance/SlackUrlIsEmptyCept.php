<?php
use Codeception\Module\Cli;
use Codeception\Scenario;

/** @var Scenario $scenario */
/** @var AcceptanceTester|Cli $I */
$I = new AcceptanceTester($scenario);

// SLACK_URL is empty
putenv('SLACK_URL_IS_EMPTY=1');

$I->runShellCommand('./slack.php "#zabbix" OK "HOST: Zabbix server
TRIGGER_NAME: www.example.com is down
TRIGGER_STATUS: OK
TRIGGER_SEVERITY: Average
DATETIME: 2016.02.17 22:02:37
ITEM_ID: 24544
ITEM_NAME: Failed step of scenario "www.example.com".
ITEM_KEY: web.test.fail[www.example.com]
ITEM_VALUE: 0
EVENT_ID: 14582
TRIGGER_URL:"', false);

$I->seeInShellOutput('SLACK_URL is empty.');
