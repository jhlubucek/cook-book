# Online cook-book

This is a template for docker run symphony app

## Configuration
docker-compose -> ports etc

## Installation


projec can be run with docker-compose with simple command
```bash
docker-compose up -d --build
```
### composer instalation might be needed
go to the container
```bash
docker exec -it [docker id/name] bash
```

then create symfony skeleton
```bash
composer install
```

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

## License
[MIT](https://choosealicense.com/licenses/mit/)