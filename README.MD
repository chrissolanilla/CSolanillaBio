## Techranger Website

Built with [Jekyll](https://jekyllrb.com/).  Use the [Jekyll Quick Start Guide](https://jekyllrb.com/docs/quickstart/) to install the requirements.

## Setting up your environment

If you are doing this for the first time run these commands:

`brew install ruby`

`gem install bundle`

`bundle install`

`bundle exec jekyll serve`

You can now view the site at localhost:4000

## Run a local development server

`bundle exec jekyll serve`

## Build and Deploy

`bundle exec jekyll build`

`bundle exec rake deploy`

`bundle exec rake invalidate_cache`

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
