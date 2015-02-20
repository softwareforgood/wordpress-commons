# Opensource Commons
----

The Opensource Commons is a project originally built by [RE-AMP](http://www.reamp.org/) and [Software for Good](http://www.softwareforgood.com) which aims to help organizations move their communication online and collaborate digitally.

Built using [Wordpress](http://www.wordpress.org) and [Buddypress](http://www.buddypress.org) (plus many more plugins) the Commons is relatively simple to setup with some familiarity with those tools.

## Installation & Setup
This project assumes some familiarity with setting up a [Wordpress site](https://codex.wordpress.org/Installing_WordPress). 

The only code checked into the repository in the `wp-content` directory containing plugins and themes and a default database with some basic plugin configuration and pages to get up and running quickly. I also highly recommend using [wp-cli](http://wp-cli.org/) to make your wordpress life a little easier. 

###To get running locally
* create your new project directory and `cd` into it
* clone this project
* Create your database
* Import the starter database. By default, the URL is [http://opensource-commons.dev](http://opensource-commons.dev)

####With WP-CLI (see docs for more parameters)

* `wp core download`
* `wp core config --dbname=<yourdatabasename> --dbuser=<yourdatabaseuser>`
* `wp user create <login> <email> --role=administrator`
* Navigate to your URL and familiarize yourself with your new community!


## Updating

## Contributing

## License
GPLv2