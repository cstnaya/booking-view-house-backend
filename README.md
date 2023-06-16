<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## fortify cheat sheet

因為我找不到官方 fortify api 規格文件，最後找到這個。

-   網址：[Here](https://sam-ngu.medium.com/laravel-fortify-cheat-sheet-a2f5cc1e85b4)

## Handle SPA auth response 401 error

如果你是前後端分離開發，前端在 A port；後端在 B port，sanctum 在設置使用者 session ENV 時得需要額外設定，否則會設定失敗，然後回傳 401 unauthenticated。

-   設定方式請看這篇教學：[Here](https://stackoverflow.com/a/67693998)

## resource

這份專案有稍微參考以前看的教學，github 連結請看此。

-   [Here](https://github.com/vueschool/laravel-course-backend/tree/main)

## Tools

1. fortify
2. sanctum

## Run on local

```sh
composer install
```

```sh
php artisan serve

# or if you use sail

sail up
```
