# GFD - Games For Days

## Description

This project aims to be something like GoodReads, but for video games. 

You'll be (hopefully) able to search for any game, view popular and recent ones, and add whatever you want to your wishlist/library.

## Setup

You will need a Twitch API account, with a generated Client ID and Client Secret.

After cloning, copy .env-example to .env 

`cp .env-example .env`

Open it with your favourite editor and enter your details. 

You may also need to set up a new user in MySQL and grant admin privileges.

Then, do:

```docker-compose up -d
docker-compose exec app composer install
docker-compose exec node npm install && npm run dev
docker-compose exec app php artisan key:generate
```

Go to your localhost and the app should be running!
