#!/bin/ash

# Run using
# docker run --rm -it -v $(pwd):/website ruby:2.4.2-alpine3.4 /website/docker_build.sh

cd /website
apk add --no-cache build-base
bundle
rm -rf _site/
bundle exec jekyll build
