# Способ с Использованием Rcon

## 📝 Краткое Описание

>Это способ, который работает с Minecraft сервером, подключаясь к нему по протоколу Rcon и передавая консольную команду.

>Для использования требуется **вебсервер** с установленным **php**, а так-же открытый порт, чтобы мониторинг мог достучаться до `вебсервера`.

## 📈 Плюсы и Минусы

Плюсы:

- Лёгок в использовании.
- Работает с любыми плагинами.

Минусы:

- Может работать не со всеми ядрами.
- Требует дополнительное ПО.

## 🧾 Требования

- Для использования вам потребуется **вебсервер** с установленным **php**, например **Nginx** + **php-fpm**.
- Открытый порт для работы с мониторингом.

## 🎓 Установка

Установка -
* Для использования вам нужно установить вербсервер, например [**Nginx**](https://www.nginx.com/) и **php-fpm**.
> Пример для ОС ubuntu 20.04:
```sh
sudo apt update
sudo apt install nginx
sudo apt install php8.1-fpm
```
Далее выполняем команды, чтобы убедиться, что всё установилось
```sh
sudo systemctl status php8.1-fpm
sudo systemctl status nginx
```
Если в ответе получаем ` Active: active (php-fpm running)` и  `Active: active (Nginx running)`, то переходим к настройке Nginx вебсервера.
Выполняем команду
```sh
sudo nano /etc/nginx/sites-available/rewards.conf
```
Вставляем туда и заменяем значения `listen 30330;` и `root /var/www/html;` на нужные, или оставляем как есть.
```conf
server {
    listen 30330;
    root /var/www/html;
    server_name _;
    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/run/php/php8.1-fpm.sock;
    }
}
```
Далее выполняем команды
```sh
ln /etc/nginx/sites-available/rewards.conf /etc/nginx/sites-enabled/rewards.conf
sudo systemctl restart php8.1-fpm
sudo systemctl restart nginx
```
Всё, веб сервер с поддержкой PHP установлен. Далее нужно открть порт, если используете **UFW**, то это можно сделать с помощью команды `sudo ufw allow in 30330/tcp` (тут нужно указать порт как в конфиге Nginx).
А если используете IPTables, то порт открть можно командой `sudo iptables -t filter -A INPUT -p tcp --dport 30330 -j ACCEPT` (тут нужно указать порт как в конфиге Nginx).

## ⚙️ Примеры Конфигураций

>todo