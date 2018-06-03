# PowerShell Empire Web


PowerShell Empire Web utilizes the [Empire REST API Server](https://github.com/EmpireProject/Empire/wiki/RESTful-API). It is a web interface for using [PowerShell Empire](https://github.com/EmpireProject/Empire/).


# Run Empire REST API Server


Get PowerShell Empire: https://github.com/EmpireProject/Empire

```
./empire --rest --restport <port> --username <empire_username> --password <empire_password>
```
For example:
```
./empire --rest --restport 1337 --username admin --password 3mpir3adm!n
```

# Requirements


PHP Curl should be installed to use Empire Web.


## Install PHP Curl

```
sudo apt-get install php7.0-curl php5-curl
```


## To check for PHP Curl

Command Line:
```
root@kali:~# php -i | grep -i curl
/etc/php/7.2/cli/conf.d/20-curl.ini,
curl
cURL support => enabled
cURL Information => 7.60.0
```

PHP Script:
```
<?php
echo (function_exists('curl_version') ? "Curl found": "Curl not found");
?>
```


# Important


CSRF protection has not been implemented because it was affecting the working of Empire Web. It will be implemented in the next release.


Stay Calm. Stay Secure. Contribute :)


# Screenshots


![empire-web-login](https://user-images.githubusercontent.com/5358495/40887141-8e4953a4-6761-11e8-8cd2-57e7a85d7220.png)

![empire-web-about](https://user-images.githubusercontent.com/5358495/40887146-9aef4294-6761-11e8-944d-c773ddec7563.png)

![empire-web-agent-cmd](https://user-images.githubusercontent.com/5358495/40887155-b5143ef4-6761-11e8-997a-438491226548.png)

![empire-web-dashboard](https://user-images.githubusercontent.com/5358495/40887153-ad0d1424-6761-11e8-8697-28f774dcc30f.png)
