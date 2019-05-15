## Techranger Website

Built with [Jekyll](https://jekyllrb.com/).  Use the [Jekyll Quick Start Guide](https://jekyllrb.com/docs/quickstart/) to install the requirements.

## Setting up your environment

If you are doing this for the first time run these commands.

Running Jekyll natively on your machine is preferred, so try that option first.

If your file permissions are being a pain, or you want to use the same environment that jenkins uses to deploy - we've included a dockerfile you can use to build a reliable Docker container that has ruby and all the gems you need.

### Using Docker

In the top directory of this project, run:

`docker build --rm -t ruby-tr-site-build-container .`

Here's a breakdown of that command:

* `--rm`: remove container intermediate containers created when building
* `-t ruby-tr-site-build-container`: tag the resulting image to make it easier to identify
* `.`: look in this directory for a dockerfile to use for building the image

### Just MacOS

Use homebrew to install ruby, though you may not need to depending on the version included in OSX.

`brew install ruby`

`gem install bundle`

... And finally in the root of this git project, run:

`bundle install`

## Run a local development server

Once you start the jekyll server, you can view the site at [http://localhost:4000](http://localhost:4000) or [http://127.0.0.1:4000](http://127.0.0.1:4000).  It will rebuild every time you make a change.

Depending on your setup, the following instructions should get your dev server running.

### Docker

`docker run --rm -p 4000:4000 -p 35729:35729 -v "$(pwd)":/website ruby-tr-site-build-container bundle exec rake dev_docker`

Here's a breakdown of that command:

* `docker`: well, we're using the docker engine to do stuff
* `run`: this will start a container and execute a command we provide
* `--rm`: remove container after running
* `-p 4000:4000`: connect this machine's port 4000 to the container's port 4000 (we'll use for the website)
* `-p 35729:35729`: port used for the livereload server
* `-v "$(pwd)":/website`: mount a volume on the container, left side being the current directory `($pwd)`, right side being the place it's mounted in the container `/website`
* `ruby-tr-site-build-container`: the docker image to execute our command in
* `bundle exec rake dev_docker`: the command being run inside the container (in this case our rake command)

### MacOS

Just `bundle exec rake dev`

## Build and Deploy

### Rake tasks

We've built a handful of rake tasks that are easy to use.  Note that these are used on Jenkins to deploy the website, so adding post-processing to the build_for_deploy script is an option.

Run `rake -T` to list all available tasks

```bash
$ bundle exec rake -T

rake build_for_deploy                                  # Build for deploy
rake deploy_production[bucket]                         # Publish website to S3
rake dev                                               # build and watch for dev
rake invalidate_cdn_cache[cloudfront_distribution_id]  # Clears cache from cloudfront
rake show_invalidations[cloudfront_distribution_id]    # show cloudfront invalidations
```

### Docker

`docker run --rm -v "$(pwd)":/website ruby-tr-site-build-container bundle exec rake build_for_deploy`

### MacOS

`bundle exec rake build_for_deploy`

## Adding a Bio

Follow all existing markup, style, and naming conventions already used.

Use [_techranger_template.html](_techranger_template.html) to get started with a complete list of variables.

1. Make an issue on this project and create a branch following the naming convention `issue/###-title-of-issue`, where `###` is the issue number.
2. Add your bio to the `_techrangers_current` directory (first_last.html)
3. Add a 250x250 image to `assets/images/bios/first_last.jpg`
4. Test site locally
5. Issue a pull request to master and notify Jacob

## Adding a job posting

To add a job posting, create a page named `_techrangers_current/hiring.html` containing:

```
---
override_url: https://URL_TO_JOB_POSTING
name: Now Hiring
title: Techranger Lead Developer
date: 2025-11-28
---
```
