# syncer
Syncer tool for databases. Currently supports mysql databases. The tool assumes the origin connection is local (therefore
it doesn't support ssh, but it will in the future)

The tool was intended to assist with syncing a database between two locations over an ssh connection.

## Requirements:

* PHP 5.5.9
* Mysql
* SSH public key authentication

## Available Commands and Help:

Run the `list` command to see the list of available commands. 

```sh
syncer list
```

If you need the details of any particular command, check the available help instructions for the command. For example
if I wanted to get some help on the `push` command I would run:

```sh
syncer help push
```

## Connection Settings

You specify the connection settings in a file `.syncer.settings.yml` which resides in the tool's root directory. If the file 
is not available you may generate a sample file with the following command: 

```sh
syncer settings:generate
```

If there is already a `.syncer.settings.yml` file you may quickly check the connection settings with:

```sh
syncer settings:list
```

The settings file contains data sources with ssh and/or database connection settings. For example the following:

```yml
    local:
        database:
            username: db-user
            password: db-password
            database: db-name
```
 
 specifies the settings for a data location with the name `local` which has connection settings for a mysql database. 
 
 The following:
 
 
    remote:
       ssh:
             host: '127.0.0.1:24'
             username: vagrant
             private-key: ~/.ssh/id_rsa
       database:
             host: localhost
             username: homestead
             password: secret
             database: ncarb_demo_test2

specifies the connection settings for a data location with the name `remote` which has the settings on how to connect to the server and
how to connect to the database. 

When you use the tool you will use the data location's names (see bellow in the Usage section)

## Usage

This is the main command you would want to run. For example if I have two data locations, a `local` data locations which 
specifies a database in my local environment and a I have a `remote` location which specifies a database on a server in the cloud,
 I would use the following command to sync them:
 
 ```sh
 syncer --from local --to remote
 ```

## TODO:

* Implement origin connections over ssh
* add automatic detection for drupal and expression engine settings
- Add port settings for the database connections
- Split out port settings from the host setting for the ssh connections
- add ssh connection detection for default key unless specified in the settings file

  

