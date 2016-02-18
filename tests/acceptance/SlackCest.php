<?php

class SlackCest
{
    public function _before()
    {
        putenv('SLACK_URL_IS_EMPTY=');
    }

    // tests
    public function tryToTest(TestGuy $I)
    {
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
TRIGGER_URL:"');

        $I->seeInShellOutput('{"channel":"#zabbix","username":"Zabbix","attachments":[{"color":"good","pretext":"OK: www.example.com is down 0","fallback":"OK: www.example.com is down 0","text":"https:\/\/example.com\/zabbix\/","fields":[{"title":"Host","value":"Zabbix server","short":true},{"title":"DateTime","value":"2016.02.17 22:02:37","short":true},{"title":"Item","value":"Failed step of scenario www.example.com.\nweb.test.fail[www.example.com] = 0","short":false}]}],"icon_emoji":":ghost:"}');
    }
}