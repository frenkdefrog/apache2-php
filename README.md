# Learn (practice) PHP with Docker envs

## How to use it?
1. Just clone this repository
2. Change the variables in the compose file. Further information please refer to the docker-compose documentation.
3. Run `docker compose up` command to start the stack.
4. When you finished the work simply run `docker compose down` command.

## What is included?
1. webserver and php processor container (all-in-one) (will be available -most likely - on http://127.0.0.1)
2. mariadb database container. No port is exposed, only phpmyadmin and webserver container should use it.
3. composer (separated) container
4. phpmyadmin container. will be available on port 8080, most likely: http://127.0.0.1:8080

## What to handle carefully?
Please mind that this compose stack uses standalone docker secrets. The used secret files are located within `docker/secrets` path. To make the database container work properly, please create the following two files:

1. `mysql_password.txt` -> this holds the password for mysql_user defined in compose file
2. `mysql_root_password.txt` -> this holds the root password for database container

>Never, never, NEVER push the content of these files to any git repository (not even into private repos)!

## Settings?
If you need to modify any apache2 (httpd) or php related settings, just simply modify the `docker/apache2/my-httpd.conf` then restart the stack. Fore more information about the settings refer to the official Apache2 and PHP documentation. This is out of the scope of this documentation.