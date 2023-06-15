# Config API
```
Thay đổi mật khẩu SQL trong file api/config.php
```

# Config Nginx
Thêm đoạn mã này vào config của trang web
```
location /client/ {
    try_files $uri $uri/client /client/index.html;
}
```

# Create SQL
```
B1 > Thay đổi mật khẩu SQL trong file build/sql/init.sh
B2 > cd build/sql && ./init.sh
```

# Start Socket Server
```
cd socket && npm run start
```
