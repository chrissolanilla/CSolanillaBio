#!/usr/bin/env bash

# This script builds the docker image for the Techrangers site so that it can be
# launched as a container in the docker run script.

echo "Running site.  Press Ctrl+C to quit."
echo "docker run --rm -p 4000:4000 -p 35729:35729 --platform linux/amd64 -v "$(pwd)":/website ruby-tr-site-build-container bundle exec rake dev_docker"
docker run --rm -p 4000:4000 -p 35729:35729 --platform linux/amd64 -v "$(pwd)":/website ruby-tr-site-build-container bundle exec rake dev_docker