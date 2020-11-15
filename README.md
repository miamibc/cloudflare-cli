<h1>
    <img title="Cloudflare" alt="Cloudflare" height="100" src="https://www.cloudflare.com/img/logo-cloudflare-dark.svg"/> cli
</h1>

Command-line client of [Cloudflare API](https://api.cloudflare.com/) written in PHP. Allows to:
- Execute Cloudflare API commands, like listing available `zones` or changing `zones:settings:development_mode`
- Parse documentation 
- Generate commands from parsed information (Not completed yet)

## Start cloudflare-cli

Download the latest binary 
```
wget https://raw.githubusercontent.com/miamibc/cloudflare-cli/main/build/cloudflare-cli
```

### Create API token

To work with Cloudflare from `cloudflare-cli`, you need to [create an API token](https://developers.cloudflare.com/api/tokens/create) with all necessary permissions and pass it as env variable. 

You have at least two ways do it (change xxxxxx to your API token):

1. Create `.env` file with `CLOUDFLARE_API_TOKEN` variable set
    ```
    echo 'CLOUDFLARE_API_TOKEN="xxxxxx"' > .env
    ```

2. Or export as a Bash variable
    
    ```
    export CLOUDFLARE_API_TOKEN="xxxxxx"
    ```

Now you can check, is it set properly, by running
```
php cloudflare-cli.phar user:tokens:verify
```

If you did setup correctly, you will see `id` and `status` of your API token.

### Make it executable and globally accessible

You can make cloudflare-cli executable and execute from bash
```
chmod a+x cloudflare-cli.phar
./cloudflare-cli.phar
```

After that you can make it visible system-wide
```
sudo ln -s $(pwd)/cloudflare-cli.phar /usr/bin/cloudflare-cli
```

Now you can run it as a simple bash command from any directory

```
cloudflare-cli
```

## Work with cloudflare-cli

To get list of all commands available, run cloudflare-cli without arguments

```
cloudflare-cli
```

To get more information on command, add `help` and `command` you need to get help for, for example

```
cloudflare-cli help zones:settings:development_mode
```

## Extend cloudflare-cli

Project is made with help of [Laravel Zero](https://laravel-zero.com/) framework.

### Install

Clone the project source code

```
git clone https://github.com/miamibc/cloudflare-cli.git
```

Go to the created directory

```
cd cloudflare-cli
```

Install composer dependencies

```
composer install
```

### Add new command

Create new command
```
php cloudflare-cli make:command
```

And add functionality to the new file in `app/Commands` directory.

You can add `App\Cloudflare\Client $client` as a parameter of `handle()` method, to inject very simple and useful Cloudflare client, that performs authorization, results pagination and possibility to parse documentation.

### Test

To test components, run phpunit
```
php vendor/bin/phpunit
```

### Create binary

To create phar file, use this command and answer few questions
```
php cloudflare-cli app:build
```

Built phar file can be found in `binary` folder.


## Support the development

Do you like this project? Support it by donating by [PayPal Donate](https://www.paypal.com/donate?hosted_button_id=VWYANQXDSRRG4)

## License

Cloudflare-cli is an open-source software licensed under the [MIT license](https://github.com/miamibc/cloudflare-cli/blob/main/LICENSE.md).

[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://github.com/miamibc/cloudflare-cli/blob/main/LICENSE.md)
