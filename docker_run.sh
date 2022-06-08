#!/usr/bin/env bash

# This script runs the docker container for the Techrangers site usign the docker
# image you created earlier.

echo "Running site.  Press Ctrl+C to quit."
echo "docker run --rm -p 4000:4000 -p 35729:35729 --platform linux/amd64 -v "$(pwd)":/website ruby-tr-site-build-container bundle exec rake dev_docker"
docker run --rm -p 4000:4000 -p 35729:35729 --platform linux/amd64 -v "$(pwd)":/website ruby-tr-site-build-container bundle exec rake dev_docker