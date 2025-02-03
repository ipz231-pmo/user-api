# Postman docs
[Link](https://documenter.getpostman.com/view/41648814/2sAYX3phcp)

# How to run
Clone repository

git clone https://github.com/ipz231-pmo/user-api

Then you need to install all dependencies

cd user-api

composer update

Then you need to genereta rsa key. To do that first create a dir where key is stored:

mkdir config/jwt

Then you need to generate rsa key

if you are using Windows you can generate rsa keys using Git

**THIS COMMAND WORKS ONLY IN CMD AND DO NOT WORK IN POWER SHELL **

"C:/Program Files/Git/usr/bin/openssl.exe" genrsa -out config/jwt/private.pem

"C:/Program Files/Git/usr/bin/openssl.exe" rsa -in config/jwt/private.pem -pubout > config/jwt/public.pem

Then start server using command:

symfony server:start
