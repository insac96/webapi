# Config Nginx
location /client/ {
    try_files $uri $uri/client /client/index.html;
}

# Init SQL
cd sql && ./init.sh
