This is a small script I whipped up in about 15 minutes because my web server was slow, and I wanted to be able to see the load and it's evolution, as well as being able to record to show the people I buy the hosting from how bad things really are ;)
___
Requirements
---
* Mysql, although it is trivial to modify the script to use, say a flat text file for data storage
* A linux server (can't get the server load on windows)
* With access to `cron`
* javascript on the client side

___
Installation
---
* Copy wherever you want on your web server
* Change the `define`d constants to your values
* Update your crontab to fetch this url every minute

For this last point, it all depends on your web host, sometimes you can create cron tasks from your administration panel, such as cPanel, otherwise, you'll have to login with ssh.


The first case is generally pretty easy:
just choose how often the load should be updated and put the following command in the command field of your graphical interface: 

    php /full/path/to/your/file/uptime.php savetodb

Of course, change the path to the full path to your file...

If you have to edit your own crontab, just type `crontab -e`  in the shell to edit and then put the following line, modified to suit:

    */10 * * * * php /full/path/to/your/file/uptime.php savetodb

This will record a new data point to database every 10 minutes. for something that will run for a long time, I feel it is more than enough, but I'll leave that up to you
