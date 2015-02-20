# Opensource Commons
----

The Opensource Commons is a project originally built by [RE-AMP](http://www.reamp.org/) and [Software for Good](http://www.softwareforgood.com) which aims to help organizations move their communication online and collaborate digitally.

Built using [Wordpress](http://www.wordpress.org) and [Buddypress](http://www.buddypress.org) (plus many more plugins) the Commons is relatively simple to setup with some familiarity with those tools.

## Installation & Setup
This project assumes some familiarity with setting up a [Wordpress site](https://codex.wordpress.org/Installing_WordPress). 

The only code checked into the repository in the `wp-content` directory containing plugins and themes and a default database with some basic plugin configuration and pages to get up and running quickly. I also highly recommend using [wp-cli](http://wp-cli.org/) to make your wordpress life a little easier. 

###Install
* create your new project directory and `cd` into it
* clone this project
* Create your database
* Import the starter database. By default, the URL is [http://opensource-commons.dev](http://opensource-commons.dev)

#####With WP-CLI (see docs for more parameters)

* `wp core download`
* `wp core config --dbname=<yourdatabasename> --dbuser=<yourdatabaseuser>`
* `wp user create <login> <email> --role=administrator`

######Old Fashioned Way
* Download the [Wordpress zip](https://wordpress.org/download/) and unpack it
* Copy everything but the `wp-content` directory into your project
* Visit [http://opensource-commons.dev](http://opensource-commons.dev) and follow the famous 5-minute install. Note that you may need to manually create your `wp-config.php` from the generated content.

###Login
Visit [http://opensource-commons.dev](http://opensource-commons.dev) and sign in with the user you created on the command line or with the credentials below. You should be all setup! You can access the dashboard at [http://opensource-commons.dev/wp-admin](http://opensource-commons.dev/wp-admin). Note that you will want to update the admin URL under "General Settings" and delete the default user as soon as you have a new admin setup.


```
osc-admin
sIer0waI5His7bO4
```

## License
This project is released free for use under [GPLv2.0](wordpress-commons/gnu-gpl-v2.0.md). 