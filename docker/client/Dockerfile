FROM centos:7

WORKDIR /var/www/html

RUN yum -y update \
    && yum -y install curl httpd git make \
    && curl --silent --location https://rpm.nodesource.com/setup_13.x | bash - \
    && yum -y install nodejs

ENV TZ="America/Sao_Paulo"
RUN date

ENV NVM_DIR /usr/local/nvm
ENV NODE_VERSION 14.0.0

# Install nvm with node and npm
RUN curl https://raw.githubusercontent.com/creationix/nvm/v0.30.1/install.sh | bash \
    && source $NVM_DIR/nvm.sh \
    && nvm install $NODE_VERSION \
    && nvm alias default $NODE_VERSION \
    && nvm use default

ENV NODE_PATH $NVM_DIR/v$NODE_VERSION/lib/node_modules
ENV PATH      $NVM_DIR/versions/node/v$NODE_VERSION/bin:$PATH

COPY build/build.sh /usr/local/bin/build.sh

RUN chmod 777 -R /var/www/html/

CMD [ "sh", "-c", "/usr/local/bin/build.sh ; httpd -DFOREGROUND"]
