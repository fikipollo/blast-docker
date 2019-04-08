#!/usr/bin/env bash

version=$(head -1 VERSION | awk '{sub(/v/,"",$1); print $1}')
sudo docker build -t fikipollo/blast:${version}  -t fikipollo/blast:latest .
