#!/usr/bin/env bash

# This script builds the docker image for the Techrangers site so that it can be
# launched as a container in the docker run script.

echo "Building site"
echo "docker build --rm -t ruby-tr-site-build-container --platform linux/amd64 ."
docker build --rm -t ruby-tr-site-build-container --platform linux/amd64 .