#!/bin/bash
docker run -dit --name phonebook -p 8080:80 -v ~/phone-book:/opt/lampp/htdocs aks060/phonebook:latest