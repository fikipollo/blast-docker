BLAST docker
===================
BLAST finds regions of similarity between biological sequences. The program compares nucleotide or protein	sequences to sequence databases and calculates the statistical significance.

This docker image extends and distributes the following software:

#### BLAST
- Basic Local Alignment Search Tool
- [BLAST is Public Domain software](https://www.ncbi.nlm.nih.gov/IEB/ToolBox/CPP_DOC/book/redirector.cgi?url=%2Fbooks%2Fbr.fcgi%3Fbook%3Dtoolkit%26part%3Dtoolkit.fm#A3).
- Citation
> Basic local alignment search tool. Altschul SF, Gish W, Miller W, Myers EW, Lipman DJ. J Mol Biol. 1990 Oct 5;215(3):403-10. [Link](https://www.ncbi.nlm.nih.gov/pubmed/2231712).
> BLAST+: architecture and applications. Camacho C, Coulouris G, Avagyan V, Ma N, Papadopoulos J, Bealer K, Madden TL. BMC Bioinformatics. 2009 Dec 15;10:421. doi: 10.1186/1471-2105-10-421. [Link](https://www.ncbi.nlm.nih.gov/pubmed/20003500).

#### Sequenceserver
- [Docker image](https://hub.docker.com/r/wurmlab/sequenceserver/).
- [Licensed under GNU AGPL version 3.](https://raw.githubusercontent.com/wurmlab/sequenceserver/master/LICENSE.txt).
- Citation
> Priyam A, Woodcroft BJ, Rai V, Munagala A, Moghul I, Ter F, Gibbins MA, Moon H, Leonard G, Rumpf W & Wurm Y. 2015. Sequenceserver: A modern graphical user interface for custom BLAST databases. biorxiv doi: 10.1101/033142. [Link](http://www.biorxiv.org/content/early/2015/11/27/033142).

# Build the image
The docker image for BLAST can be found in the [docker hub](https://hub.docker.com/r/fikipollo/blast/). However, you can rebuild is manually by running **docker build**.

```sh
sudo docker build -t blast .
```
Note that the current working directory must contain the Dockerfile file.

## Running the Container
The recommended way for running your BLAST docker is using the provided **docker-compose** script that resolves the dependencies and make easier to customize your instance. Alternatively you can run the docker manually.

## Quickstart

This procedure starts BLAST in a standard virtualised environment.

- Install [docker](https://docs.docker.com/engine/installation/) for your system if not previously done.
- `docker run -it -p 8072:80 fikipollo/blast`
- BLAST will be available at [http://localhost:8072/](http://localhost:8072/)

## Using the docker-compose file
Launching your BLAST docker is really easy using docker-compose. Just download the *docker-compose.yml* file and customize the content according to your needs. There are few settings that should be change in the file, follow the instructions in the file to configure your container.
To launch the container, type:
```sh
sudo docker-compose up
```
Using the *-d* flag you can launch the containers in background.

In case you do not have the Container stored locally, docker will download it for you.

# Install the image
You can run manually your containers using the following commands:

```sh
sudo docker run --name blast -v /your/data/location/blast-data:/home -e ADMIN_USER=youradminuser -e ADMIN_PASS=supersecret -p 8072:80 -d fikipollo/blast
```

In case you do not have the Container stored locally, docker will download it for you.

A short description of the parameters would be:
- `docker run` will run the container for you.

- `-p 8072:80` will make the port 80 (inside of the container) available on port 8072 on your host.
    Inside the container a BLAST server is running on port 8072 and that port can be bound to a local port on your host computer.

- `fikipollo/blast` is the Image name, which can be found in the [docker hub](https://hub.docker.com/r/fikipollo/blast/).

- `-d` will start the docker container in daemon mode.

- `-e VARIABLE_NAME=VALUE` changes the default value for a system variable.
The BLAST docker accepts the following variables that modify the behavior of the system in the docker.

    - **ADMIN_USER**, the name for the admin account. Using this account you can access to the admin portal (e.g. [http://yourserver:8072/admin.php](http://yourserver:8072/admin.php)) and manipulate the registered users in the system.
    - **ADMIN_PASS**, the password for the admin user.
    - **MAX_FILE_SIZE**, max file size for file upload (in MB). Bigger files should be uploaded using other protocol (e.g. using FTP).


# Version log
  - v0.9 April 2019: Fixed issues with TmpGifs (Issue #1)
  - v0.1 September 2017: First version of the docker.
