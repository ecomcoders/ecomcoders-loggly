# Magento 2 Module for centralized  cloud logging via Loggly

The purpose of this module is to provide a simple solution to submit Magento 2 log messages to Loggly. It uses RSyslog (UDP) Protocol to transfer data what is much more faster and non blocking in contrast to regular HTTPS requests. 

In the current status the module submits log messages and also generated reports to Loggly by adding an additional Monolog handler via DI.

It is also implements uploading of php error log files using a cron job.

To use it, a valid Loggly token/account is needed.

Configuration options can be found under Stores/Configuration/Developer/Loggly Syslog UDP Logger