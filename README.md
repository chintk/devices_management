## Devices Management system

### External packages
1. dompdf
    * URL
    [https://github.com/dompdf/dompdf](https://github.com/dompdf/dompdf)
    * Tutorial
    [http://www.sitepoint.com/convert-html-to-pdf-with-dompdf/](http://www.sitepoint.com/convert-html-to-pdf-with-dompdf/)

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
    * Enable apache writing to export folder
    ```
    sudo chmod -R 777 application/export
    ```
3. Composer install
    ```
    composer install
    ```
4. Git submodule install
    ```
    git submodule init
    git submodule update
    ```
