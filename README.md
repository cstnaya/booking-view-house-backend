<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## Target

預約看房的系統

## Tools

1. fortify
2. sanctum
3. mysql
4. redis
5. vue (front-end, SPA)
6. AWS S3 (todo)
7. cics (todo)

## Structure

1. client
    - upload metadata service
    - upload files service
2. House Service
    - upload metadata service
    - upload files service
3. Order Service
    - be careful for the lock
4. Comment Service
5. Bookmark service

## Features

-   [x] CRUD houses
-   [ ] cache house data
-   [x] CRUD orders
-   [ ] cache order data
-   [ ] CRUD bookmarks
-   [ ] cache bookmarks
-   [ ] CRUD comments
-   [ ] cache comments
-   [ ] CRUD house photos
-   [ ] cron job for creating fake data
-   [ ] read/write db replication
-   [ ] indexing
-   [ ] pagination
-   [x] add lock for writing order

## Models

-   [x] User
-   [x] House
-   [x] Order
-   [ ] Comment
-   [ ] Bookmark
-   [ ] HousePhoto

## Run on local

```sh
composer install
```

```sh
php artisan serve

# or if you use sail

sail up
```
