## Techranger Website

Built with [Jekyll](https://jekyllrb.com/).  Use the [Jekyll Quick Start Guide](https://jekyllrb.com/docs/quickstart/) to install the requirements.

## Setting up your environment

If you are doing this for the first time run these commands:

### Using Docker

`docker build --rm -t ruby-tr-site-build-container .`

Here's a breakdown of that command:

* `--rm`: remove container intermediate containers created when building
* `-t ruby-tr-site-build-container`: tag the resulting image to make it esier to identify
* `.`: look in this directory for a dockerfile to use for building the image

### Just MacOS

`brew install ruby`

`gem install bundle`

`bundle install`

## Run a local development server

Once you start the jekyll server, you can view the site at [http://localhost:4000](http://localhost:4000) or [http://127.0.0.1:4000](http://127.0.0.1:4000).  It will rebuild every time you make a change.

### Docker

`docker run --rm -p 4000:4000 -v "$(pwd)":/website ruby-tr-site-build-container bundle exec jekyll serve --host=0.0.0.0`

Here's a breakdown of that command:

* `--rm`: remove container after running
* `-p 4000:4000`: connect this machine's port 4000 to the container's port 4000
* `-v "$(pwd)":/website`: mount a volume on the container, left side being the current directory `($pwd)`, right side being the place it's mounted in the container `/website`
* `ruby-tr-site-build-container`: the docker image to use
* `bundle exec jekyll serve --host=0.0.0.0`: the command being run inside the container
* `--host=0.0.0.0`: causes jekyll to bind to 0.0.0.0 inside the container to make sure requests from our host are heard by jekyll

### MacOS

`bundle exec jekyll serve`

## Build and Deploy

### Docker

`docker run --rm -v "$(pwd)":/website ruby-tr-site-build-container bundle exec jekyll build`

### MacOS

`bundle exec jekyll build`

## Bonus rake tasks

`bundle exec rake deploy_production`

`bundle exec rake invalidate_cdn_cache`

## Adding a Bio

Follow all existing markup, style, and naming conventions already used.

1. Make an issue and branch following the typical naming convention
2. Add your bio to the `_techrangers_current` directory (first_last.html)
3. Add a 100x100 thumbnail to `assets/images/bios_thumbnails/first_last.jpg`
4. Add a 300x300 image to `assets/images/bios/first_last.jpg`
6. Test site locally
7. Issue a pull request and notify Jacob

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
