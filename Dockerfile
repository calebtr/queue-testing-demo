FROM ubuntu:latest

RUN apt-get update && apt-get install -y supervisor

RUN mkdir -p /var/log/supervisor

# set up timezone
RUN apt-get install -y tzdata -y
RUN ln -fs /usr/share/zoneinfo/America/Los_Angeles /etc/localtime
RUN dpkg-reconfigure --frontend noninteractive tzdata

# download PHP
RUN apt-get update
RUN apt-get install software-properties-common -y
RUN apt update
RUN add-apt-repository ppa:ondrej/php
RUN apt-get install php7.1 -y
RUN apt-get install php7.1-bcmath -y
RUN apt-get install php7.1-mbstring -y
RUN apt-get install php7.1-zip -y
RUN apt-get install php7.1-xml -y

# Copy the current directory contents into the container at /app
ADD . /app

# Set the working directory to /app
WORKDIR /app

# Copy custom PHP.ini
COPY config/php.ini /usr/local/etc/php/

# download curl, download composer, run composer install
RUN apt-get install curl -y
RUN	curl -s https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN cd /app && \
    composer install --no-interaction --no-dev

# supervisor config
COPY config/supervisord.conf /etc/supervisor/supervisord.conf
COPY config/listeners.conf /etc/supervisor/conf.d/listeners.conf

CMD ["/usr/bin/supervisord","-n"]
