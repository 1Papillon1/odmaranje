
APP_PATH="/home/fitapp/tin.fitapp.cloud/odmaranje/odmaranje-app"

# Set permissions for all directories
find $APP_PATH -type d -exec chmod 755 {} \;

# Set permissions for all files
find $APP_PATH -type f -exec chmod 644 {} \;

# Set executable permissions for all scripts
find $APP_PATH/bin -type f -exec chmod +x {} \; 2>/dev/null

# Message after successful execution
echo "Permisije su uspešno postavljene za: $APP_PATH"