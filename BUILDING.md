# Building and Deploying

#### Table of contents
1. [General requirements](#general-requirements)
2. [Deploying with Bitbucket Pipelines](#deploying-with-bitbucket-pipelines)
3. [Manual deployment](#manual-deployment)
4. [Creating a development environment](#creating-a-development-environment)
5. [Setting up and modifying configuration files](#setting-up-and-modifying-configuration-files)
6. [Setting up automatic lobby cleanup](#setting-up-automatic-lobby-cleanup)
## General Requirements 
- Python interpreter >= 3.7 (https://www.python.org/)
- Apache installation (https://www.apache.org/)
- MySQL installation (https://www.mysql.com/)
- PHP >= 8.0.0 (https://www.php.net/)
- Phpmyadmin - recommended (https://www.phpmyadmin.net/)
- Xampp - For development environments only (https://www.apachefriends.org/)
## Deploying with Bitbucket Pipelines
Included in the repository is a bitbucket pipelines YAML file that can be used to automatically deploy the repository to a properly configured remote server. Below are the steps for configuring the remote server and bitbucket for automatic deployment.

Configuring the remote server:

1. Create a directory on the remote server that will be used for the configuration files.
2. Follow the steps outlined in the section setting up and modifying configuration files in order to create proper configuration files. *

    **NOTE**: Future updates may require updates to the game configuration. you should only include gameConfig.php in the folder if you are prepared to update your custom configuration with new constants.

3. Place the new configuration files in the new directory.

Deploying with bitbucket pipelines:

1. Fork the repository via bitbucket
2. In repository settings, under pipelines, go to repository variables
3. The deployment scripts expect that the following 6 variables be defined
    - REMOTE_PUBLIC_HTML_PATH: The complete path to the folder where the word search will be deployed. You probably want to set this to a new empty directory inside the web root.
    - REMOTE_PATH: The complete path to the folder where the backend of the word search will be deployed. For security reasons this should be set to a new empty directory **outside** the web root.
    - REMOTE_CONFIG_DIR_PATH: The complete path to the folder you created above containing the config files.
    - REMOTE_PYTHON_ACTIVATION_PATH: The complete path to the python activation binary where you want to install the generator. This path is different than the python executable path, this one should end in /activate. It is recommended that you create a new virtual environment for this purpose*
    - REMOTE_USER: The username of the remote user that will be used to install the word search
    - REMOTE_HOST: The web address/host name of the remote server
4. Our bitbucket pipelines file uses SSH keys for securely logging into the remote server. You should add your SSH key pair under repository settings -> SSH keys. You may also need to add the remote server to the known host list. Bitbucket will automatically use this key pair for SSH/SFTP when running the deployment script. For help on SSH keys in Bitbucket Pipelines, see this article: https://support.atlassian.com/bitbucket-cloud/docs/using-ssh-keys-in-bitbucket-pipelines/
5. You're now ready to deploy! From the main repository page, under pipelines, click "Run Pipeline", click on the main branch, and run the deploy-to-remote-host pipeline.

**\*NOTE**: As part of the automatic deployment scripts, the REMOTE_PUBLIC_HTML_PATH and REMOTE_PATH are both cleared to prepare for the new installation. Because of this, you should not place the python virtual environment in either of these folders.

After following these steps, all that is needed in order to deploy a new installation is to run the pipeline again. 

You will still have to manually import the database  from the database folder into your mySQL installation. For information on how to import an SQL database using phpmyadmin you can refer to this article: https://docs.phpmyadmin.net/en/latest/import_export.html

## Manual Deployment
You can also manually deploy the repository to either a remote host or your local machine. These steps outline this process.

1. Clone the repository into an intermediary directory.
2. Delete the folders public_html/board/testenv and public_html/board/testenvFiles. These are for testing purposes only and should not be available in production environments.
3. Move the contents public_html directory into the desired place on the web root.
4. Create a new directory (preferrably outside the web root) and place the generator, config, and utilities folders into it.
5. Using the config files in the config folder follow the steps outlined in the section setting up and modifying configuration files in order to create proper configuration files. 
6. Move the includePath.php file to the directory where you moved the public_html folder contents to in step #2.
7. Activate the python environment that you declared in the envConfig.php file
8. cd into the generator directory and run 

    ```pip install .``` 
    
    This will install the generator on the selected python environment, which is required to generate word searches.

9. Import the database in the database folder into your mySQL installation. For information on how to import an SQL database using phpmyadmin you can refer to this article: https://docs.phpmyadmin.net/en/latest/import_export.html

10. The remaining files from the repository can be safely deleted. They are not needed in a production environment.

After following these steps, the word search should be accessible on your website from wherever it was placed in your webroot.
## Creating a development environment
For development purposes we use Xampp, a tool for windows, linux, & macOS that bundles all of the requirements needed to run the application (except python) into one easy to use tool. The following steps outline the steps necessary to run our application with Xampp.

NOTE: Xampp is intended for development purposes only. You should not use Xampp to deploy the app for production.

1. Install Xampp if not already installed (https://www.apachefriends.org/)
2. Clone the repository into a directory of your choice.
3. In the Xampp control panel, under Apache config, open httpd.conf
4. Find "DocumentRoot", and modify the path on this line and the one below it to point to the public_html directory of the repository.
5. Follow the steps outlined in the section setting up and modifying configuration files in order to create proper configuration files. 
6. Move the includePath.php file to the public_html directory
7. Go to http://localhost/phpmyadmin and import the database from the database folder into mySQL. For information on how to import an SQL database using phpmyadmin you can refer to this article: https://docs.phpmyadmin.net/en/latest/import_export.html
8. Activate the python environment that you declared in the envConfig.php file
9. cd into the generator directory and run 

    ```pip install .``` 
    
    This will install the generator on the selected python environment, which is required to generate word searches.

At this point you should have a fully functional testing environment. The home page of the word search should be accessible at http://localhost/home. 

## Setting up and modifying configuration files
The word search application makes use of three important configuration files which must be properly configured in order for the application to work properly. Follow the steps below to configure these files correctly.

**NOTE:** All paths must not contain any spaces.

**NOTE:** Windows paths are typically written with the backward slash, which can form escape sequences in PHP. It is recommended that you replace all backward slashes in Windows paths with the forward slash (/).

### envConfig.php
1. Make a copy of the default_envConfig.php and rename it to envConfig.php
2. Modify the PUBLIC_HTML_PATH definition to point to the public_html folder. 
    - For testing environments this will point to the public_html folder in the repository.
    - For deploying this will point to the folder where the public_html contents are being deployed.
3. Modify the DB_USER and DB_PASSWORD contants to the username and password of the mySQL user that will be accessing the database
    - For testing environments using Xampp the default username is "root" and the default password is the empty string.
4. Modify the PYTHON_INTERPRETER_PATH definition to point to the desired python executable to use.
    - It is highly recommended that you make a virtual environment for this purpose. 

### includePath.php
1. Copy default_includePath.php and rename it to includePath.php
2. Modify the "" of the return to point to the directory containing the config, generator, and utilities folders.
    - In testing environments this will be the same as the path to the repository
    - In bitbucket pipeline deployment this is the same as REMOTE_PATH
    - In manual deployment this is the path to the directory containing config, generator, and utiliies

### gameConfig.php
No modification is necessary to this file, but it contains many constants which you can modify to change the behavior of the application.

## Setting up automatic lobby cleanup
Included in the repository is a script (utilities/cleanupInstances.php) that will automatically delete old and expired game and lobby instances. This script can be called manually from the command line, or set up to run automatically.

**Linux:** Using cron, the cleanup script can be scheduled to run at regular intervals. An example cron job is shown below. It runs the cleanup script every 30 minutes.

```0,30 * * * * /usr/local/bin/php /home/user123/word-search/utilities/cleanupInstances.php```
