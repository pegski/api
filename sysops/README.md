# infrastructure/sysops

EC2 instance should be created manually, currently ubuntu14.04 LTS is used as base image.
 
 The commands below assume you are in the sysops/ansible directory.
 
 The docker host can be provisioned using:
 
 ```
 ansible-playbook site.yml -i hosts
 ```
 
 You are able to add your own ssh-key and it will be deployed to the server so you can log in.
 
 Add your ssh public key to ssh_access/files/public_keys and reference the file in ssh_access/vars/main.yml.
 
 Deploy the keys with:
 ```
 ansible-playbook -i hosts site.yml --tags "ssh_access"
 ```
 

 
 # deploy
 first, backup mongodb:
 ```
  sudo -s
  docker ps # check name of running mongodb container
  docker exec -it pegski_mongodb_1 bash
  cd /data/db
  rm -rf ./backup/*
  mongodump --host localhost:27017 --out ./backup/
  exit
  #now move the backup container to a safe place
  cd ~
  mv backup-mongo backup-mongo-<date>
  mv /home/ubuntu/pegski/docker/mongodb/data/backup backup-mongo
 ```
 
 After this, webski can be deployed from github by using:
 ```
 ansible-playbook -i hosts deploy/pegski.yml
 ```
 
 and for now, fix sessions afterwards:
 
 
