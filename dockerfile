# build using:
# docker build -t tr-ruby .

# run jekyll build:
# docker run --rm -v $(pwd):/website tr-ruby bundle exec jekyll build

FROM ruby:2.4.2-alpine3.4

RUN apk add --no-cache build-base

ADD Gemfile /tmp/Gemfile

RUN cd /tmp && bundle

WORKDIR /website
