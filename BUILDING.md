# Building and Deploying

#### Table of contents
1. Deploying with Bitbucket Pipelines
2. Manual deployment
3. Building a development environment
4. Setting up and modifying configuration files

## Deploying with Bitbucket Pipelines
Included in the repository is a bitbucket pipelines YAML file that can be used to automatically deploy the repository to a properly configured remote server. Here are the steps for configuring the remote server and bitbucket for automatic deployment.

Configuring the remote server:

1. Create a directory on the remote server that we will use for the configuration scripts.
2. Follow the steps outlined in the section setting up and modifying configuration files in order to create proper configuration files. 

    **NOTE**: Future updates may require updates to the game configuration. you should only include gameConfig.php in the folder if you are prepared to update your custom configuration with new constants.
3. Place the new configuration files in the new directory.

Deploying with bitbucket pipelines:

1. Fork the repository via bitbucket
2. In repository settings, under pipelines, go to repository variables
3. The deployment scripts expect that the following 6 variables be defined
    - REMOTE_PUBLIC_HTML_PATH: The complete path to the folder where the word search will be deployed. You probably want to set this to a new empty directory inside the web root.
    - REMOTE_PATH: The complete path to the folder where the backend of the word search will be deployed. You probably want to set this to a new empty directory **outside** the web root.
    - REMOTE_CONFIG_DIR_PATH: The complete path to the folder you created above containing the config files.
    - REMOTE_PYTHON_PATH: The complete path to the python installation where you want to install the generator. It is recommended that you create a new virtual environment for this purpose*
    - REMOTE_USER: The username of the remote user that will be used to install the word search
    - REMOTE_HOST: The web address/host name of the remote server
4. Our bitbucket pipelines file uses SSH keys for securely logging into the remote server. You should add your SSH key pair to under repository settings -> SSH keys. Bitbucket will automatically use this key pair for SSH/SFTP when running the deployment script. For help on SSH keys in Bitbucket Pipelines, see this article: https://support.atlassian.com/bitbucket-cloud/docs/using-ssh-keys-in-bitbucket-pipelines/
5. You're now ready to deploy! From the main repository page, under pipelines, click "Run Pipeline", click on the main branch, and run the deploy-to-remote-host pipeline.

*NOTE: As part of the automatic deployment scripts, the REMOTE_PUBLIC_HTML_PATH and REMOTE_PATH are both cleared to prepare for the new installation. Because of this, you should not place the python virtual environment in either of these folders.

After following these steps, all that is needed in order to deploy a new installation is to run the pipeline again.

