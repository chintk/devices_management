## Devices Management system

### Configuration

1. Apache configuration
    ```
    <VirtualHost *:80>
        ServerName devices_management.localhost
        DocumentRoot /var/www/html/devices_management
        <Directory /var/www/html/devices_management/ >
            AllowOverride All
        </Directory>
    </VirtualHost>
    ```

    Edit `/etc/hosts`
    ```
    127.0.0.1 devices_management.localhost
    ```

    Access web via `http://devices_management.localhost`
2. Setup
    * Database
    ```
    cp application/configs/database.default.ini application/configs/database.ini
    ```
