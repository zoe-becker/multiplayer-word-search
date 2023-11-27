source $REMOTE_PYTHON_ACTIVATION_PATH
cd "$REMOTE_PATH/generator"
pip install . 

cd ~
cp $REMOTE_CONFIG_DIR_PATH/* $REMOTE_PATH/config
mv $REMOTE_PATH/config/includePath.php $REMOTE_PUBLIC_HTML_PATH
